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

/**
 * @since 1.5.0
 */
define('_DOWN_PAYMENT_AMOUNT', 750);
require("libFunctions.php");
class CodValidationModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

//    public function postProcess()
//    {
//        if ($this->context->cart->id_customer == 0 || $this->context->cart->id_address_delivery == 0 || $this->context->cart->id_address_invoice == 0 || !$this->module->active)
//            Tools::redirectLink(__PS_BASE_URI__ . 'order.php?step=1');
//
//        // Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
//        $authorized = false;
//        foreach (Module::getPaymentModules() as $module)
//            if ($module['name'] == 'cod') {
//                $authorized = true;
//                break;
//            }
//        if (!$authorized)
//            die(Tools::displayError('This payment method is not available.'));
//
//        $customer = new Customer($this->context->cart->id_customer);
//        if (!Validate::isLoadedObject($customer))
//            Tools::redirectLink(__PS_BASE_URI__ . 'order.php?step=1');
//
//        if (Tools::getValue('confirm')) {
//            $customer = new Customer((int)$this->context->cart->id_customer);
//            $total = $this->context->cart->getOrderTotal(true, Cart::BOTH);
//            $this->module->validateOrder((int)$this->context->cart->id, Configuration::get('PS_OS_PREPARATION'), $total, $this->module->displayName, null, array(), null, false, $customer->secure_key);
//            Tools::redirectLink(__PS_BASE_URI__ . 'order-confirmation.php?key=' . $customer->secure_key . '&id_cart=' . (int)$this->context->cart->id . '&id_module=' . (int)$this->module->id . '&id_order=' . (int)$this->module->currentOrder);
//        }
//    }

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        $context = Context::getContext();

        $isCODAllowed = true;

        $orderProducts = $context->cart->getProducts();
        $totalProductsQuantityCount = 0;


        foreach ($orderProducts as $product) {
            $totalProductsQuantityCount += $product['cart_quantity'];
        }

        if ($totalProductsQuantityCount > 1) {
            $isCODAllowed = false;
            $errorMsg = 'product_count_error';

        } elseif ($context->cart->getOrderTotal(true, Cart::BOTH) < 2000) {
            $isCODAllowed = false;
            $errorMsg = 'order_total_error';
        } else {
            //add custom code to allow cod for pin codes if user pin code lie in the list then allow else reject
            $cart_delivery_option = $this->context->cart->getDeliveryOption();
            $errorsString = 'Sorry currently we are not providing COD service to address you have chosen for delivery.Go back and change Address or choose different payment option. \r\n\n Errors in following postal codes: \n\n';
            $addressErrors = array();
            foreach ($cart_delivery_option as $key => $deliveryAddressId) {
                $delivery = new Address($key);
                $status = $this->checkCODAvailability($delivery->postcode);
                if (!$status) {
                    $isCODAllowed = false;
                    $errorsString .= $delivery->postcode;
                    $addressErrors[] = $delivery;
                    $errorMsg = 'address_error';
                }
            }

        }

        //check for the product is back order or not
        if ($isCODAllowed) {
            $productDetail = Product::getProductProperties($context->language->id, array('id_product' => $orderProducts[0]['id_product']));
            if ($productDetail['quantity'] <= 0) {
                $isCODAllowed = false;
                $errorMsg = 'quantity_error';
            }

        }


        if (!$isCODAllowed) {
            $redirect = __PS_BASE_URI__ . 'order?multi-shipping=1&step=3';
            header('Location: ' . $redirect);
            exit;
        }

        $orderTotal = $context->cart->getOrderTotal();
        $Order_Id = 'COD_' . (int)$context->cart->id;
        $billing = new Address($context->cart->id_address_invoice);
        $billing_state = $billing->id_state ? new State($billing->id_state) : false;

        $merchantId = Tools::safeOutput(Configuration::get('CCAVENUE_MERCHANT_ID'));
        $workingKey = Configuration::get('CCAVENUE_WORKING_KEY');
        $delivery = new Address($context->cart->id_address_delivery);
        $delivery_state = $delivery->id_state ? new State($delivery->id_state) : false;

        $Redirect_Url = 'http://' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/cod/validation.php'; //your redirect URL where your customer will be redirected after authorisation from CCAvenue


        $this->context->smarty->assign(array(
            'ccAvenue_merchant_id' => $merchantId,
            'ccAvenue_order_id' => $Order_Id,
            'ccAvenue_redirect_link' => $Redirect_Url,
            'billing_cust_name' => $billing->firstname . ' ' . $billing->lastname,
            'billing_cust_address' => $billing->address1 . ' ' . $billing->address2,
            'billing_cust_country' => $billing->country,
            'billing_cust_state' => $billing->id_state ? $billing_state->name : '',
            'billing_city' => $billing->city,
            'billing_zip' => $billing->postcode,
            'billing_cust_tel' => ($billing->phone) ? $billing->phone : $billing->phone_mobile,
            'billing_cust_email' => $context->customer->email,
            'delivery_cust_name' => $delivery->firstname . '' . $delivery->lastname,
            'delivery_cust_address' => $delivery->address1 . '' . $delivery->address2,
            'delivery_cust_country' => $delivery->country,
            'delivery_cust_state' => $delivery->id_state ? $delivery_state->name : '',
            'delivery_city' => $delivery->city,
            'delivery_zip' => $delivery->postcode,
            'delivery_cust_tel' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
            'delivery_cust_email' => $context->customer->email,
        ));

        if ($orderTotal <= 20750) {
            $ccAvenue_checksum = getChecksum($merchantId, $Order_Id, 750, $Redirect_Url, $workingKey);
            $this->context->smarty->assign(array(
                'total' => $this->context->cart->getOrderTotal(true, Cart::BOTH),
                'this_path' => $this->module->getPathUri(),
                'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
                'totalAdvance' => 0,
                'totalAtCOD' => $orderTotal - 750,
                'ccAvenue_amount' => 750,
                'ccAvenue_checksum' => $ccAvenue_checksum
            ));


        } else {
            $amount = $orderTotal - 20750 + 750;
            $ccAvenue_checksum = getChecksum($merchantId, $Order_Id, $amount, $Redirect_Url, $workingKey);
            $this->context->smarty->assign(array(
                'total' => $this->context->cart->getOrderTotal(true, Cart::BOTH),
                'this_path' => $this->module->getPathUri(),
                'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
                'totalAdvance' => $orderTotal - 20750,
                'totalAtCOD' => 20000,
                'ccAvenue_amount' => $orderTotal - 20750 + 750,
                'ccAvenue_checksum' => $ccAvenue_checksum
            ));
        }
        $this->setTemplate('validation.tpl');
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


}
