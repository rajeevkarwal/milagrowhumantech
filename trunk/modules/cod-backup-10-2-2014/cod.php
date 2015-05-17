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

require("integral_evolution/libFunctions.php");
define('_MERCHANT_ID', 'M_milagrow_6881');
define('_DOWN_PAYMENT_AMOUNT', 750);
define('_BILLING_PAGE_HEADING', 'Milagrow HumanTech COD(Cash On Delivery)');
class COD extends PaymentModule
{
    public function __construct()
    {
        $this->name = 'cod';
        $this->tab = 'payments_gateways';
        $this->version = '1.0';
        $this->author = 'GAPS';
        $this->need_instance = 1;

        $this->currencies = true;
        $this->currencies_mode = 'radio';

        parent::__construct();

        $this->displayName = $this->l('COD');
        $this->description = $this->l('Accept cash on delivery payments developed by GAPS New');

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
        return true;
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

        //add custom code to allow cod for pin codes if user pin code lie in the list then allow else reject
        $cart_delivery_option = $this->context->cart->getDeliveryOption();
        $isCODAllowed = true;
        $errorsString = 'Sorry currently we are not providing COD service to address you have chosen for delivery.Go back and change Address or choose different payment option. \r\n\n Errors in following postal codes: \n\n';
        $addressErrors=array();
        foreach ($cart_delivery_option as $key => $deliveryAddressId) {
            $delivery = new Address($key);
            $status = $this->checkCODAvailability($delivery->postcode);
            if (!$status) {
                $isCODAllowed = false;
                $errorsString .= $delivery->postcode;
                $addressErrors[]=$delivery;
            }
        }
        //end --------------------------->>>>>>>>>>>>>>>>>>>

        $smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
            'cod_available' => $isCODAllowed,
            'error' => $errorsString,
            'addressErrors'=>$addressErrors
        ));

        return $this->display(__FILE__, 'payment.tpl');
    }

    public static function getShopDomainSsl($http = false, $entities = false)
    {
        if (method_exists('Tools', 'getShopDomainSsl'))
            return Tools::getShopDomainSsl($http, $entities);
    }

    private function checkCODAvailability($pincode)
    {
        $sql = 'select cod_available from ' . _DB_PREFIX_ . 'pincode_cod where pincode=\'' . $pincode . '\'';
        $row = Db::getInstance()->getRow($sql);
        if ($row)
            return $row['cod_available'];
        else
            return 0;
    }

    public function hookpaymentReturn($params)
    {
        if (!$this->active)
            return;
        global $smarty;
        //get customer delivery address and name by querying
        $id_address_delivery = $params['cart']->id_address_delivery;
        $id_address_invoice = $params['cart']->id_address_invoice;
        $Redirect_Url = Tools::getShopDomainSsl(true, true) . '/index.php?fc=module&module=' . $this->name . '&controller=paymentnotification'; //your redirect URL where your customer will be redirected after authorisation from CCAvenue
        if ($id_address_delivery == $id_address_invoice) {
            $sql = 'SELECT ' . _DB_PREFIX_ . 'address.firstname,' . _DB_PREFIX_ . 'address.lastname,address1,address2,city,postcode,phone_mobile,email,' . _DB_PREFIX_ . 'country_lang.name as country,' . _DB_PREFIX_ . 'state.name as state FROM ' . _DB_PREFIX_ . 'address join ' . _DB_PREFIX_ . 'country_lang on ' . _DB_PREFIX_ . 'country_lang.id_country=' . _DB_PREFIX_ . 'address.id_country Join ' . _DB_PREFIX_ . 'state on ' . _DB_PREFIX_ . 'address.id_state=' . _DB_PREFIX_ . 'state.id_state join ' . _DB_PREFIX_ . 'customer on ' . _DB_PREFIX_ . 'customer.id_customer=' . _DB_PREFIX_ . 'address.id_customer WHERE id_address =' . $id_address_invoice;
            if ($row = Db::getInstance()->getRow($sql)) {
                $billing_cust_name = $row['firstname'] . '' . $row['lastname'];
                $billing_cust_address = $row['address1'] . '' . $row['address2'];
                $billing_cust_country = $row['country'];
                $billing_cust_state = $row['state'];
                $billing_city = $row['city'];
                $billing_zip = $row['postcode'];
                $billing_cust_tel = $row['phone_mobile'];
                $billing_cust_email = $row['email'];

                $delivery_cust_name = $billing_cust_name;
                $delivery_cust_address = $billing_cust_address;
                $delivery_cust_country = $billing_cust_country;
                $delivery_cust_state = $billing_cust_state;
                $delivery_city = $billing_city;
                $delivery_zip = $billing_zip;
                $delivery_cust_tel = $billing_cust_tel;
                $delivery_cust_email = $billing_cust_email;
                $delivery_cust_notes = "Down Payment";
                $billingPageHeading = _BILLING_PAGE_HEADING;
            }
        } else {
            $sql = 'SELECT ' . _DB_PREFIX_ . 'address.firstname' . _DB_PREFIX_ . 'address.lastname,address1,address2,city,postcode,phone_mobile,email,' . _DB_PREFIX_ . 'country_lang.name as country,' . _DB_PREFIX_ . 'state.name as state FROM ' . _DB_PREFIX_ . 'address join ' . _DB_PREFIX_ . 'country_lang on ' . _DB_PREFIX_ . 'country_lang.id_country=' . _DB_PREFIX_ . 'address.id_country Join ' . _DB_PREFIX_ . 'state on ' . _DB_PREFIX_ . 'address.id_state=' . _DB_PREFIX_ . 'state.id_state join ' . _DB_PREFIX_ . 'customer on ' . _DB_PREFIX_ . 'customer.id_customer=' . _DB_PREFIX_ . 'address.id_customer where id_address in(' . "'$id_address_invoice'," . "'$id_address_delivery'";
            if ($results = Db::getInstance()->ExecuteS($sql))
                foreach ($results as $row) {
                    if ($row['addressId'] == $id_address_delivery) {
                        $delivery_cust_name = $row['firstname'] . '' . $row['lastname'];
                        $delivery_cust_address = $row['address1'] . '' . $row['address2'];
                        $delivery_cust_country = $row['country'];
                        $delivery_cust_state = $row['state'];
                        $delivery_city = $row['city'];
                        $delivery_zip = $row['postcode'];
                        $delivery_cust_tel = $row['phone_mobile'];
                        $delivery_cust_email = $row['email'];
                    }
                    if ($row['addressId'] == $id_address_invoice) {
                        $billing_cust_name = $row['firstname'] . '' . $row['lastname'];
                        $billing_cust_address = $row['address1'] . '' . $row['address2'];
                        $billing_cust_country = $row['country'];
                        $billing_cust_state = $row['state'];
                        $billing_city = $row['city'];
                        $billing_zip = $row['postcode'];
                        $billing_cust_tel = $row['phone_mobile'];
                        $billing_cust_email = $row['email'];
                    }
                    $billingPageHeading = _BILLING_PAGE_HEADING;
                    $delivery_cust_notes = "Down Payment";
                }

        }

        $Merchant_Id = _MERCHANT_ID; //This id(also User_Id)  available at "Generate Working Key" of "Settings & Options"
        $Order_Id = $params['objOrder']->reference; //your script should substitute the order description here in the quotes provided here
        $Amount = $this->getAdvanceCODAmount($Order_Id); //your script should substitute the amount here in the quotes provided here
        $WorkingKey = "f6srdljv9krmyof389tjdixf86bgmc55"; //put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key login to your

        $Checksum = getChecksum($Merchant_Id, $Order_Id, $Amount, $Redirect_Url, $WorkingKey);

        $smarty->assign(array(
            'Merchant_id' => _MERCHANT_ID,
            'amount' => $Amount,
            'redirectLink' => $Redirect_Url,
            'Order_Id' => $params['objOrder']->reference,
            'delivery_cust_name' => $delivery_cust_name,
            'delivery_cust_address' => $delivery_cust_address,
            'delivery_cust_country' => $delivery_cust_country,
            'delivery_cust_state' => $delivery_cust_state,
            'delivery_city' => $delivery_city,
            'delivery_zip' => $delivery_zip,
            'delivery_cust_tel' => $delivery_cust_tel,
            'delivery_cust_email' => $delivery_cust_email,
            'billing_cust_name' => $billing_cust_name,
            'billing_cust_address' => $billing_cust_address,
            'billing_cust_country' => $billing_cust_country,
            'billing_cust_state' => $billing_cust_state,
            'billing_city' => $billing_city,
            'billing_zip' => $billing_zip,
            'billing_cust_tel' => $billing_cust_tel,
            'billing_cust_email' => $billing_cust_email,
            'billingPageHeading' => $billingPageHeading,
            'delivery_cust_notes' => $delivery_cust_notes,
            'checksum' => $Checksum,
        ));

        return $this->display(__FILE__, 'confirmation.tpl');
    }

    private function getAmountForAdvancePayment($orderReference)
    {
        $sql = 'Select * from ' . _DB_PREFIX_ . 'orders where reference=\'' . $orderReference . '\'';
        $advancePayment = 0;
        if ($results = Db::getInstance()->ExecuteS($sql))
            foreach ($results as $row) {
                if ($row['total_paid'] >= _DOWN_PAYMENT_AMOUNT && $row['total_paid'] <= 40000)
                    $advancePayment += 750;
                else
                    $advancePayment += $row['total_paid'];

            }
        return $advancePayment;
    }


    private function getAdvanceCODAmount($orderReference)
    {
        $sql = 'Select * from ' . _DB_PREFIX_ . 'orders where reference=\'' . $orderReference . '\' order by id_order';
        $orderIds = array();
        $orderWiseTotalAmount = array();
        $advancePayment = 0;
        if ($results = Db::getInstance()->ExecuteS($sql)) {
            foreach ($results as $row) {
                $orderIds[] = $row['id_order'];
                $orderWiseTotalAmount[$row['id_order']] = $row['total_paid'];
            }
        }

        $orderDetailKeyValuePair = array();
        if (!empty($orderIds)) {
            $ordersDetailsSQl = 'Select * from ' . _DB_PREFIX_ . 'order_detail where id_order in (' . implode(',', $orderIds) . ')';
            if ($ordersDetails = Db::getInstance()->ExecuteS($ordersDetailsSQl)) {
                foreach ($ordersDetails as $row) {
                    $orderDetailKeyValuePair[$row['id_order']][] = $row;
                }
            }

            foreach ($orderDetailKeyValuePair as $orderId => $entry) {
                $countCODDisableStatus = 0;
                $orderAmount = $orderWiseTotalAmount[$orderId];
                $orderWiseAdvancePayment = 0;
                $productWiseArray = array();
                foreach ($entry as $product) {
                    if ($product['unit_price_tax_incl'] >= 2000 && $product['unit_price_tax_incl'] <= 20000) {
                        $codStatus = true;
                    } else {
                        $countCODDisableStatus++;
                        $codStatus = false;
                    }
                    $productWiseArray['product'][] = array('codStatus' => $codStatus, 'price' => $product['unit_price_tax_incl'], 'quantity' => $product['product_quantity']);

                }
                if ($countCODDisableStatus == count($productWiseArray['product'])) {
                    $orderWiseAdvancePayment += $orderAmount;
                } else {
                    foreach ($productWiseArray['product'] as $row) {
                        if ($row['price'] >= 2000 && $row['price'] <= 20000) {
                            $orderWiseAdvancePayment += (750 * $row['quantity']);
                        } else {
                            $orderWiseAdvancePayment += ($row['price'] * $row['quantity']);
                        }

                    }
                }
                $balanceCOD = $orderAmount - $orderWiseAdvancePayment;
                if ($balanceCOD >= 20000)
                    $orderWiseAdvancePayment = ($orderAmount - 20000);
                $advancePayment += $orderWiseAdvancePayment;
            }
        }

        return $advancePayment;
    }

    /******************************************************************/
    /** Add payment state: COD: Payment Pending ******************/
    /** For order that are still in pending verification **************/
    /******************************************************************/
    private function _addState()
    {
        $orderState = new OrderState();
        $orderState->name = array();
        foreach (Language::getLanguages() as $language)
            $orderState->name[$language['id_lang']] = $this->l('CCAvenue: Payment Pending');
        $orderState->send_email = false;
        $orderState->color = '#DDEEFF';
        $orderState->hidden = false;
        $orderState->delivery = false;
        $orderState->logable = true;
        if ($orderState->add())
            copy(dirname(__FILE__) . '/logo.gif', dirname(__FILE__) . '/../../img/os/' . (int)$orderState->id . '.gif');
        return $orderState->id;
    }
}
