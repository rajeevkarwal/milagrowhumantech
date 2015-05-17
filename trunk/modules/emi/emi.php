<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
    exit;
require 'emiLibFunctions.php';
define('_CCAVENUE_EMI_SUCCESS', 'Thank you placing the order, %s of amount Rs. %s. Your order is being processed. Please check your email for additional details.');
define('_CCAVENUE_EMI_LOGISTIC_EMAIL', 'outboundlogistics@milagrow.in');
define('_CCAVENUE_EMI_RECEIVABLE_EMAIL', 'receivables@milagrow.in');
//define('_CCAVENUE_EMI_LOGISTIC_EMAIL', 'ptailor@greenapplesolutions.com');
//define('_CCAVENUE_EMI_RECEIVABLE_EMAIL', 'ptailor@greenapplesolutions.com');
class EMI extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'emi';
        $this->tab = 'payments_gateways';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 1;

        $this->currencies = true;
        $this->currencies_mode = 'radio';

        parent::__construct();

        $this->displayName = $this->l('Citibank EMI');
        $this->description = $this->l('Accept EMI payments developed by GAPS');

        /* For 1.4.3 and less compatibility */
        $updateConfig = array('PS_OS_CHEQUE', 'PS_OS_PAYMENT', 'PS_OS_PREPARATION', 'PS_OS_SHIPPING', 'PS_OS_CANCELED', 'PS_OS_REFUND', 'PS_OS_ERROR', 'PS_OS_OUTOFSTOCK', 'PS_OS_BANKWIRE', 'PS_OS_PAYPAL', 'PS_OS_WS_PAYMENT');
        if (!Configuration::get('PS_OS_PAYMENT'))
            foreach ($updateConfig as $u)
                if (!Configuration::get($u) && defined('_' . $u . '_'))
                    Configuration::updateValue($u, constant('_' . $u . '_'));
    }

    public function install()
    {
        if (!parent::install() OR !$this->registerHook('payment') OR !$this->registerHook('paymentReturn'))
            return false;
        Configuration::updateValue('_MERCHANT_ID_EMI_CCAVENUE_3', 'M_vij43235_43235');
        Configuration::updateValue('CCAVENUE_EMI_PENDING_STATUS', $this->_addState());
        Configuration::updateValue('_MERCHANT_ID_EMI_CCAVENUE_6', 'M_vij43236_43236');
        Configuration::updateValue('WORKING_KEY_EMI_3_MONTHS', 'ob3gqjsbkhtces00bo');
        Configuration::updateValue('WORKING_KEY_EMI_6_MONTHS', '2y5ml9w1g0irsctv3q');
        Configuration::updateValue('EMI_CCAVENUE_3_MONTHS_TAX', 2);
        Configuration::updateValue('EMI_CCAVENUE_6_MONTHS_TAX', 4);
        return true;
    }

    /******************************************************************/
    /** Add payment state: EMI: Payment Pending ******************/
    /** For order that are still in pending verification **************/
    /******************************************************************/
    private function _addState()
    {
        $orderState = new OrderState();
        $orderState->name = array();
        foreach (Language::getLanguages() as $language)
            $orderState->name[$language['id_lang']] = $this->l('EMI: Payment Pending');
        $orderState->send_email = false;
        $orderState->color = '#DDEEFF';
        $orderState->hidden = false;
        $orderState->delivery = false;
        $orderState->logable = true;
        if ($orderState->add())
            copy(dirname(__FILE__) . '/logo.gif', dirname(__FILE__) . '/../../img/os/' . (int)$orderState->id . '.gif');
        return $orderState->id;
    }


    public function hookPayment($params)
    {
        if (!$this->active)
            return;

        global $smarty;
        // Check if cart has product download
        foreach ($params['cart']->getProducts() AS $product) {
            $pd = ProductDownload::getIdFromIdProduct((int)($product['id_product']));
            if ($pd AND Validate::isUnsignedInt($pd))
                return false;
        }
        $context = Context::getContext();
        $orderTotal = $context->cart->getOrderTotal();


        if ($orderTotal >= 5000) {
            $smarty->assign(array(
                'this_path' => $this->_path,
                'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
            ));

            return $this->display(__FILE__, 'payment-success.tpl');
        } else {
            return $this->display(__FILE__, 'payment-disabled.tpl');
        }


    }

    /* Final validate function Called when an order was placed and CCAvenue is keeping us posted about the payment validation */
    public function validation()
    {
        $context = context::getContext();
        $card_expiration = '';
        $card_holder = '';
        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';

        //as we are not getting card number from ccavenue we are using this field for storing whether emi 3 months used or 6 months used
        $card_number = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';
        //and card holder is used to store percentage of EMI processing fee
        if ($card_number == '3_months') {
            $card_holder = Configuration::get('EMI_CCAVENUE_3_MONTHS_TAX');
            $workingKey = Configuration::get('WORKING_KEY_EMI_3_MONTHS');
            $merchantIdUsed = Configuration::get('_MERCHANT_ID_EMI_CCAVENUE_3');
            $context->cookie->emi = $this->getEMIAmount($this->context->cart->getOrderTotal(true, Cart::BOTH), $Amount);
        } elseif ($card_number == '6_months') {
            $card_holder = Configuration::get('EMI_CCAVENUE_6_MONTHS_TAX');
            $merchantIdUsed = Configuration::get('_MERCHANT_ID_EMI_CCAVENUE_6');
            $workingKey = Configuration::get('WORKING_KEY_EMI_6_MONTHS');
            $context->cookie->emi = $this->getEMIAmount($this->context->cart->getOrderTotal(true, Cart::BOTH), $Amount);
        }
        $Checksum = verifyChecksumEMI($merchantIdUsed, $OrderId, $Amount, $AuthDesc, $workingKey, $avnChecksum);
        $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
        $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
        $billing_cust_state = isset($_REQUEST["billing_cust_state"]) ? $_REQUEST["billing_cust_state"] : '';
        $billing_cust_city = isset($_REQUEST["billing_cust_city"]) ? $_REQUEST["billing_cust_city"] : '';
        $billing_zip_code = isset($_REQUEST["billing_zip_code"]) ? $_REQUEST["billing_zip_code"] : '';
        $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
        $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
        $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';

        $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
        $cart_id = (int)str_replace('EMI_', '', $OrderId);
        $cart = new Cart($cart_id);
        $extraVars = array('transaction_id' => $nb_order_no);
        if ($Checksum && $AuthDesc == 'Y') {
            $this->validateOrder((int)$cart->id, (int)Configuration::get('PS_OS_PAYMENT'), (float)$Amount,$this->displayName, 'Your credit card has been charged and the transaction is successful', $extraVars, null, false, $cart->secure_key);

            //finding order for EMI
            $orders = $this->getAllOrdersForGivenCart((int)$cart->id);
            $orderWiseAdvancePaymentMapping = array();
            $orderWiseAmount = $this->getEMIPaymentAmountOrderWise($orders, $card_holder);
            $existing_id_currency = 1;
            $existing_conversion_rate = 1.000000;
            if (!empty($orders)) {
                $orderReference = $orders[0]['reference'];
            }
            foreach ($orders as $key => $singleOrder) {
                $EMIPayment = $orderWiseAmount[$singleOrder['id_order']];
                Db::getInstance()->insert('order_payment', array(
                    'id_currency' => (int)$existing_id_currency,
                    'amount' => $EMIPayment,
                    'payment_method' => pSQL('EMI'),
                    'conversion_rate' => $existing_conversion_rate,
                    'transaction_id' => $nb_order_no,
                    'card_number' => $card_number,
                    'card_brand' => $card_category,
                    'card_expiration' => $card_expiration,
                    'card_holder' => $card_holder,
                    'date_add' => date('Y-m-d H:i:s'),
                    'order_reference' => $orderReference
                ));
                $last_insert_payment_id = Db::getInstance()->insert_id();
                Db::getInstance()->insert('order_invoice_payment', array(
                    'id_order_invoice' => (int)$singleOrder['invoice_number'],
                    'id_order_payment' => (int)($last_insert_payment_id),
                    'id_order' => (int)($singleOrder['id_order']),
                ));
                $orderWiseAdvancePaymentMapping[] = array('amount' => $EMIPayment, 'orderId' => $singleOrder['id_order'], 'reference' => $singleOrder['reference'] . '#' . ($key + 1), 'id_address_delivery' => $singleOrder['id_address_delivery']);
            }

            //removing EMI Amount from cookie
            $context->cookie->emi = null;
            $billingAddress = array('firstname' => $billing_cust_name, 'lastname' => '', 'state' => $billing_cust_state, 'phone' => $billing_cust_tel, 'postcode' => $billing_zip_code, 'city' => $billing_cust_city, 'address1' => $billing_cust_address, 'address2' => '', 'country' => $billing_cust_country);
            $billing = new Address($context->cart->id_address_invoice);
            $SMS_Mobile = $billing->phone_mobile;
            $this->sendMessage($orderReference, $Amount, $SMS_Mobile);

            $i=0;
            foreach ($orderWiseAdvancePaymentMapping as $orderEntry) {
                $customer_message_sql = 'Select message from ' . _DB_PREFIX_ . 'message Where id_cart = '. $cart_id . ' ';
                $customer_message = Db::getInstance()->ExecuteS($customer_message_sql);

                $order_status = new OrderState((int)$orders[$i++]['current_state'], (int)$this->context->language->id);
                $order_payment_status = (int)$order_status->paid;

                $this->sendEmailToCustomer($billingAddress, $orderEntry['reference'], $orderEntry['orderId'], $card_holder, $card_number,$order_payment_status,$customer_message[0]['message']);
            }

            if ($order_payment_status) {
                $redirect = __PS_BASE_URI__ . 'module/emi/success';
                header('Location: ' . $redirect);
                exit;
            } else {
                $redirect = __PS_BASE_URI__ . 'module/emi/error';
                header('Location: ' . $redirect);
                exit;
            }

//            $redirect = __PS_BASE_URI__ . 'module/emi/success';
//            header('Location: ' . $redirect);
            exit;
        } elseif ($Checksum && $AuthDesc === "B") {
            $this->validateOrder((int)$cart->id, (int)Configuration::get('CCAVENUE_EMI_PENDING_STATUS'), (float)$Amount, $this->displayName, $this->l('The transaction is in pending verification'), $extraVars, null, false, $cart->secure_key);
            //finding order for EMI
            $orders = $this->getAllOrdersForGivenCart((int)$cart->id);
            $orderWiseAdvancePaymentMapping = array();
            $orderWiseAmount = $this->getEMIPaymentAmountOrderWise($orders, $card_holder);
            $existing_id_currency = 1;
            $existing_conversion_rate = 1.000000;
            if (!empty($orders)) {
                $orderReference = $orders[0]['reference'];
            }
            foreach ($orders as $key => $singleOrder) {
                $EMIPayment = $orderWiseAmount[$singleOrder['id_order']];
                Db::getInstance()->insert('order_payment', array(
                    'id_currency' => (int)$existing_id_currency,
                    'amount' => $EMIPayment,
                    'payment_method' => pSQL('EMI'),
                    'conversion_rate' => $existing_conversion_rate,
                    'transaction_id' => $nb_order_no,
                    'card_number' => $card_number,
                    'card_brand' => $card_category,
                    'card_expiration' => $card_expiration,
                    'card_holder' => $card_holder,
                    'date_add' => date('Y-m-d H:i:s'),
                    'order_reference' => $orderReference
                ));
                $last_insert_payment_id = Db::getInstance()->insert_id();
                Db::getInstance()->insert('order_invoice_payment', array(
                    'id_order_invoice' => (int)$singleOrder['invoice_number'],
                    'id_order_payment' => (int)($last_insert_payment_id),
                    'id_order' => (int)($singleOrder['id_order']),
                ));
                $orderWiseAdvancePaymentMapping[] = array('amount' => $EMIPayment, 'orderId' => $singleOrder['id_order'], 'reference' => $singleOrder['reference'] . '#' . ($key + 1), 'id_address_delivery' => $singleOrder['id_address_delivery']);
            }

            //removing EMI Amount from cookie
            $context->cookie->emi = null;
            $redirect = __PS_BASE_URI__ . 'module/emi/success';
            header('Location: ' . $redirect);
            exit;
        } elseif ($Checksum && $AuthDesc === "N") {
            $this->validateOrder((int)$cart->id, (int)Configuration::get('PS_OS_ERROR'), (float)$Amount, $this->displayName, $this->l('The transaction has been declined'), $extraVars, null, false, $cart->secure_key);

            $orders = $this->getAllOrdersForGivenCart((int)$cart->id);
            $orderWiseAdvancePaymentMapping = array();
            $orderWiseAmount = $this->getEMIPaymentAmountOrderWise($orders, $card_holder);

            foreach ($orders as $key => $singleOrder) {
                $EMIPayment = $orderWiseAmount[$singleOrder['id_order']];
                $orderWiseAdvancePaymentMapping[] = array('amount' => $EMIPayment, 'orderId' => $singleOrder['id_order'], 'reference' => $singleOrder['reference'] . '#' . ($key + 1), 'id_address_delivery' => $singleOrder['id_address_delivery']);
            }

            $context->cookie->emi = null;
            $billingAddress = array('firstname' => $billing_cust_name, 'lastname' => '', 'state' => $billing_cust_state, 'phone' => $billing_cust_tel, 'postcode' => $billing_zip_code, 'city' => $billing_cust_city, 'address1' => $billing_cust_address, 'address2' => '', 'country' => $billing_cust_country);

            $i=0;
            foreach ($orderWiseAdvancePaymentMapping as $orderEntry) {
                $customer_message_sql = 'Select message from ' . _DB_PREFIX_ . 'message Where id_cart = '. $cart_id . ' ';
                $customer_message = Db::getInstance()->ExecuteS($customer_message_sql);

                $order_status = new OrderState((int)$orders[$i++]['current_state'], (int)$this->context->language->id);
                $order_payment_status = (int)$order_status->paid;

                $this->sendEmailToCustomer($billingAddress, $orderEntry['reference'], $orderEntry['orderId'], $card_holder, $card_number,$order_payment_status,$customer_message[0]['message']);
            }

            //no need to map any order entry

            $redirect = __PS_BASE_URI__ . 'module/emi/error';
            header('Location: ' . $redirect);
            exit;


        } else {
            $redirect = __PS_BASE_URI__ . 'module/emi/error';
            $context->cookie->emi = null;
            header('Location: ' . $redirect);
            exit;
        }

    }


    /* test validation function for success case */

    //test function for testing payment status pending
//    public function validation()
//    {
//        $context = context::getContext();
//        $card_expiration = '';
//        $card_holder = '';
//        $MerchantId = isset($_REQUEST["Merchant_Id"]) ? $_REQUEST["Merchant_Id"] : '';
//        $OrderId = isset($_REQUEST["Order_Id"]) ? $_REQUEST["Order_Id"] : '';
//        $Amount = isset($_REQUEST["Amount"]) ? $_REQUEST["Amount"] : '';
//        $AuthDesc = isset($_REQUEST["AuthDesc"]) ? $_REQUEST["AuthDesc"] : '';
//        $avnChecksum = isset($_REQUEST["Checksum"]) ? $_REQUEST["Checksum"] : '';
//        $nb_order_no = isset($_REQUEST["nb_order_no"]) ? $_REQUEST['nb_order_no'] : '';
//
//        //as we are not getting card number from ccavenue we are using this field for storing whether emi 3 months used or 6 months used
//        $card_number = isset($_REQUEST["Merchant_Param"]) ? $_REQUEST["Merchant_Param"] : '';
//        //and card holder is used to store percentage of EMI processing fee
//        if ($card_number == '3_months') {
//            $card_holder = Configuration::get('EMI_CCAVENUE_3_MONTHS_TAX');
//            $workingKey = Configuration::get('WORKING_KEY_EMI_3_MONTHS');
//            $merchantIdUsed = Configuration::get('_MERCHANT_ID_EMI_CCAVENUE_3');
//            $context->cookie->emi = $this->getEMIAmount($this->context->cart->getOrderTotal(true, Cart::BOTH), $Amount);
//        } elseif ($card_number == '6_months') {
//            $card_holder = Configuration::get('EMI_CCAVENUE_6_MONTHS_TAX');
//            $merchantIdUsed = Configuration::get('_MERCHANT_ID_EMI_CCAVENUE_6');
//            $workingKey = Configuration::get('WORKING_KEY_EMI_6_MONTHS');
//            $context->cookie->emi = $this->getEMIAmount($this->context->cart->getOrderTotal(true, Cart::BOTH), $Amount);
//        }
//        $Checksum = verifyChecksumEMI($merchantIdUsed, $OrderId, $Amount, $AuthDesc, $workingKey, $avnChecksum);
//        $billing_cust_name = isset($_REQUEST["billing_cust_name"]) ? $_REQUEST["billing_cust_name"] : '';
//        $billing_cust_address = isset($_REQUEST["billing_cust_address"]) ? $_REQUEST["billing_cust_address"] : '';
//        $billing_cust_state = isset($_REQUEST["billing_cust_state"]) ? $_REQUEST["billing_cust_state"] : '';
//        $billing_cust_city = isset($_REQUEST["billing_cust_city"]) ? $_REQUEST["billing_cust_city"] : '';
//        $billing_zip_code = isset($_REQUEST["billing_zip_code"]) ? $_REQUEST["billing_zip_code"] : '';
//        $billing_cust_country = isset($_REQUEST["billing_cust_country"]) ? $_REQUEST["billing_cust_country"] : '';
//        $billing_cust_tel = isset($_REQUEST["billing_cust_tel"]) ? $_REQUEST['billing_cust_tel'] : '';
//        $billing_cust_email = isset($_REQUEST["billing_cust_email"]) ? $_REQUEST["billing_cust_email"] : '';
//
//        $card_category = isset($_REQUEST["card_category"]) ? $_REQUEST["card_category"] : '';
//        $cart_id = (int)str_replace('EMI_', '', $OrderId);
//        $cart = new Cart($cart_id);
//        $extraVars = array('transaction_id' => $nb_order_no);
//
//            $this->validateOrder((int)$cart->id, (int)Configuration::get('PS_OS_PAYMENT'), (float)$Amount,$this->displayName, 'Your credit card has been charged and the transaction is successful', $extraVars, null, false, $cart->secure_key);
//
//            //finding order for EMI
//            $orders = $this->getAllOrdersForGivenCart((int)$cart->id);
//            $orderWiseAdvancePaymentMapping = array();
//            $orderWiseAmount = $this->getEMIPaymentAmountOrderWise($orders, $card_holder);
//            $existing_id_currency = 1;
//            $existing_conversion_rate = 1.000000;
//            if (!empty($orders)) {
//                $orderReference = $orders[0]['reference'];
//            }
//            foreach ($orders as $key => $singleOrder) {
//                $EMIPayment = $orderWiseAmount[$singleOrder['id_order']];
//                Db::getInstance()->insert('order_payment', array(
//                    'id_currency' => (int)$existing_id_currency,
//                    'amount' => $EMIPayment,
//                    'payment_method' => pSQL('EMI'),
//                    'conversion_rate' => $existing_conversion_rate,
//                    'transaction_id' => $nb_order_no,
//                    'card_number' => $card_number,
//                    'card_brand' => $card_category,
//                    'card_expiration' => $card_expiration,
//                    'card_holder' => $card_holder,
//                    'date_add' => date('Y-m-d H:i:s'),
//                    'order_reference' => $orderReference
//                ));
//                $last_insert_payment_id = Db::getInstance()->insert_id();
//                Db::getInstance()->insert('order_invoice_payment', array(
//                    'id_order_invoice' => (int)$singleOrder['invoice_number'],
//                    'id_order_payment' => (int)($last_insert_payment_id),
//                    'id_order' => (int)($singleOrder['id_order']),
//                ));
//                $orderWiseAdvancePaymentMapping[] = array('amount' => $EMIPayment, 'orderId' => $singleOrder['id_order'], 'reference' => $singleOrder['reference'] . '#' . ($key + 1), 'id_address_delivery' => $singleOrder['id_address_delivery']);
//            }
//
//            //removing EMI Amount from cookie
//            $context->cookie->emi = null;
//            $billingAddress = array('firstname' => $billing_cust_name, 'lastname' => '', 'state' => $billing_cust_state, 'phone' => $billing_cust_tel, 'postcode' => $billing_zip_code, 'city' => $billing_cust_city, 'address1' => $billing_cust_address, 'address2' => '', 'country' => $billing_cust_country);
//            $billing = new Address($context->cart->id_address_invoice);
//            $SMS_Mobile = $billing->phone_mobile;
//            $this->sendMessage($orderReference, $Amount, $SMS_Mobile);
//
//            $i=0;
//            foreach ($orderWiseAdvancePaymentMapping as $orderEntry) {
//                $customer_message_sql = 'Select message from ' . _DB_PREFIX_ . 'message Where id_cart = '. $cart_id . ' ';
//                $customer_message = Db::getInstance()->ExecuteS($customer_message_sql);
//
//                $order_status = new OrderState((int)$orders[$i++]['current_state'], (int)$this->context->language->id);
//                $order_payment_status = (int)$order_status->paid;
//
//                $this->sendEmailToCustomer($billingAddress, $orderEntry['reference'], $orderEntry['orderId'], $card_holder, $card_number,$order_payment_status,$customer_message[0]['message']);
//            }
//
//            if ($order_payment_status) {
//                $redirect = __PS_BASE_URI__ . 'module/emi/success';
//                header('Location: ' . $redirect);
//                exit;
//            } else {
//                $redirect = __PS_BASE_URI__ . 'module/emi/error';
//                header('Location: ' . $redirect);
//                exit;
//            }
//
////            $redirect = __PS_BASE_URI__ . 'module/emi/success';
////            header('Location: ' . $redirect);
//            exit;
//
//    }

    public static function getShopDomainSsl($http = false, $entities = false)
    {
        if (method_exists('Tools', 'getShopDomainSsl'))
            return Tools::getShopDomainSsl($http, $entities);
    }


    public function getAllOrdersForGivenCart($cartId)
    {
        $sqlQuery = 'Select * from ' . _DB_PREFIX_ . 'orders where id_cart=' . $cartId;
        $result = Db::getInstance()->executeS($sqlQuery);
        if ($result)
            return $result;
        return array();
    }

    private function getEMIAmount($cartTotal, $amountPaid)
    {
        return ($amountPaid - $cartTotal);
    }


    private function getEMIPaymentAmountOrderWise($orders, $EMIRate)
    {
        $EMIPaymentKeyValue = array();
        foreach ($orders as $orderEntry) {
            $emiProcesingFee = ($EMIRate * $orderEntry['total_paid'] / 100);
            $serviceTax = (12.36 * $emiProcesingFee / 100);
            $EMIAmountPaid = $orderEntry['total_paid'] + $emiProcesingFee + $serviceTax;
            $EMIPaymentKeyValue[$orderEntry['id_order']] = $EMIAmountPaid;
        }

        return $EMIPaymentKeyValue;

    }


    function sendMessage($orderReference, $amount, $mobile)
    {
        try {
            $message = sprintf(_CCAVENUE_EMI_SUCCESS, $orderReference, $amount);

            $username = _SMS_USERNAME;
                    $password = _SMS_PASSWORD;
		    $auth_key = _SMS_AUTH_KEY;
                    //create api url to hit
                    $sms_url = _SMS_URL;
                    $senderId = _SMS_SENDERID;
                    $sms_url = "$sms_url?authkey=$auth_key&sender=$senderId&mobiles=$mobile&message=" . urlencode($message)."&route=4";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sms_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, '6');
            $result = curl_exec($ch);
            $error = curl_error($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

        } catch (Exception $e) {
            //consuming exception
        }

    }


    private
    function sendEmailToCustomer($billingAddress, $orderReference, $orderId, $EMIRate, $EMIPlan,$order_paid_status,$customer_order_message)
    {
        $order = new Order($orderId);

        $products_list = '';
        $virtual_product = true;
//        Select ps_order_detail.product_id as id_product,ps_order_detail.product_quantity as quantity,ps_product.reference as reference,
//ps_product_lang.name as name,
//ps_orders.id_order as order_id
//from ps_orders
//join ps_order_detail on ps_orders.id_order = ps_order_detail.id_order
//join ps_product on ps_order_detail.product_id=ps_product.id_product
//join ps_product_lang on ps_product.id_product=ps_product_lang.id_product
//where ps_order_detail.id_order = 47

        //old query
//        Select ps_cart_product.id_product as id_product,ps_cart_product.id_product_attribute as id_product_attribute,ps_cart_product.quantity as cart_quantity,ps_product.reference as reference,ps_product_lang.name as name from ps_cart_product
//join ps_orders on ps_cart_product.id_cart=ps_orders.id_cart
//join ps_product on ps_cart_product.id_product=ps_product.id_product
//join ps_product_lang on ps_product.id_product=ps_product_lang.id_product
//where id_order=48
        $productsSql = 'Select ' . _DB_PREFIX_ . 'order_detail.product_id as id_product,' . _DB_PREFIX_ . 'order_detail.product_quantity as quantity,' . _DB_PREFIX_ . 'product.reference as reference,'
            . _DB_PREFIX_ . 'product_lang.name as name from ' . _DB_PREFIX_ . 'orders join '
            . _DB_PREFIX_ . 'order_detail on ' . _DB_PREFIX_ . 'orders.id_order=' . _DB_PREFIX_ . 'order_detail.id_order join '
            . _DB_PREFIX_ . 'product on ' . _DB_PREFIX_ . 'order_detail.product_id=' . _DB_PREFIX_ . 'product.id_product join '
            . _DB_PREFIX_ . 'product_lang on ' . _DB_PREFIX_ . 'product.id_product=' . _DB_PREFIX_ . 'product_lang.id_product where ' . _DB_PREFIX_ . 'order_detail.id_order=' . $orderId;
        $products = Db::getInstance()->ExecuteS($productsSql);
//        echo $productsSql;
//        echo "<pre>";print_r($products);echo "</pre>";exit;
        foreach ($products as $key => $product) {
            $productName = ProductCore::getProductName($product['id_product']);
            $price = Product::getPriceStatic((int)$product['id_product'], false, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 6, null, false, true, $product['quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
            $price_wt = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 2, null, false, true, $product['quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
//            $productName = ProductCore::getProductName($product['id_order']);
            $customization_quantity = 0;
            $customized_datas = Product::getAllCustomizedDatas((int)$order->id_cart);
            if (isset($customized_datas[$product['id_product']][$product['id_product_attribute']])) {
                $customization_text = '';
                foreach ($customized_datas[$product['id_product']][$product['id_product_attribute']][$order->id_address_delivery] as $customization) {
                    if (isset($customization['datas'][Product::CUSTOMIZE_TEXTFIELD]))
                        foreach ($customization['datas'][Product::CUSTOMIZE_TEXTFIELD] as $text)
                            $customization_text .= $text['name'] . ': ' . $text['value'] . '<br />';

                    if (isset($customization['datas'][Product::CUSTOMIZE_FILE]))
                        $customization_text .= sprintf(Tools::displayError('%d image(s)'), count($customization['datas'][Product::CUSTOMIZE_FILE])) . '<br />';
                    $customization_text .= '---<br />';
                }
                $customization_text = rtrim($customization_text, '---<br />');

                $customization_quantity = (int)$product['customization_quantity'];
                $products_list .=
                    '<tr style="background-color: ' . ($key % 2 ? '#DDE2E6' : '#EBECEE') . ';">
								<td style="padding: 0.6em 0.4em;width: 15%;">' . $product['reference'] . '</td>
								<td style="padding: 0.6em 0.4em;width: 30%;"><strong>' . $productName . '</strong></td>
								<td style="padding: 0.6em 0.4em; width: 20%;">' . Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt, $this->context->currency, false) . '</td>
								<td style="padding: 0.6em 0.4em; width: 15%;">' . $customization_quantity . '</td>
								<td style="padding: 0.6em 0.4em; width: 20%;">' . Tools::displayPrice($customization_quantity * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt), $this->context->currency, false) . '</td>
							</tr>';
            }

            if (!$customization_quantity || (int)$product['quantity'] > $customization_quantity)
                $products_list .=
                    '<tr style="background-color: ' . ($key % 2 ? '#DDE2E6' : '#EBECEE') . ';">
								<td style="padding: 0.6em 0.4em;width: 15%;">' . $product['reference'] . '</td>
								<td style="padding: 0.6em 0.4em;width: 30%;"><strong>' . $productName . '</strong></td>
								<td style="padding: 0.6em 0.4em; width: 20%;">' . Tools::displayPrice(Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt, $this->context->currency, false) . '</td>
								<td style="padding: 0.6em 0.4em; width: 15%;">' . ((int)$product['quantity']) . '</td>
								<td style="padding: 0.6em 0.4em; width: 20%;">' . Tools::displayPrice(((int)$product['quantity']) * (Product::getTaxCalculationMethod() == PS_TAX_EXC ? Tools::ps_round($price, 2) : $price_wt), $this->context->currency, false) . '</td>
							</tr>';

            // Check if is not a virutal product for the displaying of shipping
            if (!$product['is_virtual'])
                $virtual_product &= false;

        }
        $delivery = new Address($order->id_address_delivery);
        $delivery_state = $delivery->id_state ? new State($delivery->id_state) : false;


        //computing parameters for

        $totalOrderPrice = $order->total_paid;
        $emiProcessingFees = ($EMIRate * $totalOrderPrice / 100);
        $serviceTaxProcessingFees = ($emiProcessingFees * 12.36 / 100);
        $totalOrderFinal = $totalOrderPrice + $emiProcessingFees + $serviceTaxProcessingFees;

        if ($EMIPlan == '3_months')
            $EMIPlan = '3 Months';
        else
            $EMIPlan = '6 Months';

        if($customer_order_message){
            $order_message = $customer_order_message;
        }else{
            $order_message = 'No customer message';
        }


        $data = array(
            '{firstname}' => $this->context->customer->firstname,
            '{lastname}' => $this->context->customer->lastname,
            '{email}' => $this->context->customer->email,
            '{delivery_block_txt}' => $this->getFormattedDeliveryAddress($delivery, false),
            '{invoice_block_txt}' => $this->getFormattedBillingAddress($billingAddress, false),
            '{delivery_block_html}' => $this->getFormattedDeliveryAddress($delivery, true),
            '{invoice_block_html}' => $this->getFormattedBillingAddress($billingAddress, true),
            '{delivery_company}' => $delivery->company,
            '{delivery_firstname}' => $delivery->firstname,
            '{delivery_lastname}' => $delivery->lastname,
            '{delivery_address1}' => $delivery->address1,
            '{delivery_address2}' => $delivery->address2,
            '{delivery_city}' => $delivery->city,
            '{delivery_postal_code}' => $delivery->postcode,
            '{delivery_country}' => $delivery->country,
            '{delivery_state}' => $delivery->id_state ? $delivery_state->name : '',
            '{delivery_phone}' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
            '{delivery_other}' => $delivery->other,
            '{invoice_company}' => '',
            '{invoice_vat_number}' => '',
            '{invoice_firstname}' => $billingAddress['firstname'],
            '{invoice_lastname}' => $billingAddress['lastname'],
            '{invoice_address2}' => $billingAddress['address2'],
            '{invoice_address1}' => $billingAddress['address1'],
            '{invoice_city}' => $billingAddress['city'],
            '{invoice_postal_code}' => $billingAddress['postcode'],
            '{invoice_country}' => $billingAddress['country'],
            '{invoice_state}' => $billingAddress['state'],
            '{invoice_phone}' => $billingAddress['phone'],
            '{invoice_other}' => '',
            '{order_name}' => $orderReference,
            '{date}' => Tools::displayDate(date('Y-m-d H:i:s'), (int)$order->id_lang, 1),
            '{carrier}' => Tools::displayError('No carrier'),
            '{payment}' => Tools::substr($order->payment, 0, 32),
            '{products}' => $products_list,
            '{discounts}' => '',
            '{emi_tax_rate}' => $EMIRate,
            '{emi_plan}' => $EMIPlan,
            '{emi_processing_fees}' => round($emiProcessingFees, 2),
            '{service_tax_fees}' => round($serviceTaxProcessingFees, 2),
            '{total_final_paid}' => round($totalOrderFinal, 2),
            '{total_paid}' => Tools::displayPrice($order->total_paid, $this->context->currency, false),
            '{total_products}' => Tools::displayPrice($order->total_paid - $order->total_shipping - $order->total_wrapping + $order->total_discounts, $this->context->currency, false),
            '{total_discounts}' => Tools::displayPrice($order->total_discounts, $this->context->currency, false),
            '{total_shipping}' => Tools::displayPrice($order->total_shipping, $this->context->currency, false),
            '{total_wrapping}' => Tools::displayPrice($order->total_wrapping, $this->context->currency, false),
            '{customer_message}' => $order_message
        );


        // Join PDF invoice
        if ((int)Configuration::get('PS_INVOICE') && $order->invoice_number) {
            $pdf = new PDF($order->getInvoicesCollection(), PDF::TEMPLATE_INVOICE, $this->context->smarty);
            $file_attachement['content'] = $pdf->render(false);
            $file_attachement['name'] = Configuration::get('PS_INVOICE_PREFIX', (int)$order->id_lang, null, $order->id_shop) . sprintf('%06d', $order->invoice_number) . '.pdf';
            $file_attachement['mime'] = 'application/pdf';
        } else
            $file_attachement = null;

        $logisticEmail = _CCAVENUE_EMI_LOGISTIC_EMAIL;
        $receivableEmail = _CCAVENUE_EMI_RECEIVABLE_EMAIL;
        if ($order_paid_status) {

            if (Validate::isEmail($this->context->customer->email))
                Mail::Send(
                    (int)$order->id_lang,
                    'order_conf',
                    sprintf(Mail::l('Order confirmation - #%06d , Citibank EMI', (int)$order->id_lang),$order->id),
                    $data,
                    $this->context->customer->email,
                    $this->context->customer->firstname . ' ' . $this->context->customer->lastname,
                    null,
                    null,
                    $file_attachement,
                    null, getcwd() . '/', false, (int)$order->id_shop
                );

            //        if (_PS_ENVIRONMENTS) {
            //sending mail to admin
            $adminEmailErrorTemplate = 'order_conf_admin';
            $adminSubject = sprintf(Mail::l('New order Full Payment Received - #%06d , Citibank EMI', $order->id_lang), $order->id);

            Mail::Send(
                (int)$order->id_lang,
                $adminEmailErrorTemplate,
                Mail::l($adminSubject, (int)$order->id_lang),
                $data,
                $logisticEmail,
                'Administrator',
                null,
                null,
                $file_attachement,
                null, getcwd() . '/', false, (int)$order->id_shop
            );

            Mail::Send(
                (int)$order->id_lang,
                $adminEmailErrorTemplate,
                Mail::l($adminSubject, (int)$order->id_lang),
                $data,
                $receivableEmail,
                'Administrator',
                null,
                null,
                $file_attachement,
                null, getcwd() . '/', false, (int)$order->id_shop
            );
        } else {
            $adminEmailErrorTemplate = 'order_conf_admin_error';
            $adminSubject = sprintf(Mail::l('New order payment fail - #%06d , Citibank EMI', $order->id_lang), $order->id);

            Mail::Send(
                (int)$order->id_lang,
                $adminEmailErrorTemplate,
                Mail::l($adminSubject, (int)$order->id_lang),
                $data,
                $logisticEmail,
                'Administrator',
                null,
                null,
                $file_attachement,
                null, getcwd() . '/', false, (int)$order->id_shop
            );

            Mail::Send(
                (int)$order->id_lang,
                $adminEmailErrorTemplate,
                Mail::l($adminSubject, (int)$order->id_lang),
                $data,
                $receivableEmail,
                'Administrator',
                null,
                null,
                $file_attachement,
                null, getcwd() . '/', false, (int)$order->id_shop
            );
        }

    }

    private
    function getFormattedDeliveryAddress($address, $html = true)
    {
        if ($html) {
            return '<strong>' . $address->firstname . ' ' . $address->lastname . '</strong><br/>' . $address->address1 .
            '<br>' . $address->address2 . '<br>' . $address->city . ',' . $address->state . '<br>' . $address->country . '<br>' . $address->postcode;

        }

        return $address->firstname . ' ' . $address->lastname . '\r\n' . $address->address1 .
        '\r\n' . $address->address2 . '\r\n' . $address->city . ',' . $address->state . '\r\n' . $address->country . '\r\n' . $address->postcode;
    }

    private
    function getFormattedBillingAddress($address, $html = true)
    {

        if ($html) {
            return '<strong>' . $address['firstname'] . ' ' . $address['lastname'] . '</strong><br/>' . $address['address1'] .
            '<br>' . $address['address2'] . '<br>' . $address['city'] . ',' . $address['state'] . '<br>' . $address['country'] . '<br>' . $address['postcode'];

        }

        return $address['firstname'] . ' ' . $address['lastname'] . '\r\n' . $address['address1'] .
        '\r\n' . $address['address2'] . '\r\n' . $address['city'] . ',' . $address['state'] . '\r\n' . $address['country'] . '\r\n' . $address['postcode'];
    }


}
