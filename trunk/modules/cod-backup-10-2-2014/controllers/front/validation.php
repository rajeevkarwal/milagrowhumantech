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
class CodValidationModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function postProcess()
    {
        if ($this->context->cart->id_customer == 0 || $this->context->cart->id_address_delivery == 0 || $this->context->cart->id_address_invoice == 0 || !$this->module->active)
            Tools::redirectLink(__PS_BASE_URI__ . 'order.php?step=1');

        // Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
        $authorized = false;
        foreach (Module::getPaymentModules() as $module)
            if ($module['name'] == 'cod') {
                $authorized = true;
                break;
            }
        if (!$authorized)
            die(Tools::displayError('This payment method is not available.'));

        $customer = new Customer($this->context->cart->id_customer);
        if (!Validate::isLoadedObject($customer))
            Tools::redirectLink(__PS_BASE_URI__ . 'order.php?step=1');

        if (Tools::getValue('confirm')) {
            $customer = new Customer((int)$this->context->cart->id_customer);
            $total = $this->context->cart->getOrderTotal(true, Cart::BOTH);
            $this->module->validateOrder((int)$this->context->cart->id, Configuration::get('PS_OS_PREPARATION'), $total, $this->module->displayName, null, array(), null, false, $customer->secure_key);
            Tools::redirectLink(__PS_BASE_URI__ . 'order-confirmation.php?key=' . $customer->secure_key . '&id_cart=' . (int)$this->context->cart->id . '&id_module=' . (int)$this->module->id . '&id_order=' . (int)$this->module->currentOrder);
        }
    }

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $this->display_column_left = false;
        parent::initContent();
        //getting products added to the cart and preparing table to show whether COD is available on the products or NOT
        //start ------------------------->>>>>>>>>>>>>>>>>>>

//        $this->context->cart = new Cart($id_cart);
//        $this->context->customer = new Customer($this->context->cart->id_customer);
//        $this->context->language = new Language($this->context->cart->id_lang);
//        $this->context->shop = ($shop ? $shop : new Shop($this->context->cart->id_shop));
        $id_currency = (int)$this->context->cart->id_currency;
        $this->context->currency = new Currency($id_currency, null, $this->context->shop->id);
        if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery')
            $context_country = $this->context->country;

        // For each package, generate an order
        $delivery_option_list = $this->context->cart->getDeliveryOptionList();
        $package_list = $this->context->cart->getPackageList();
        $cart_delivery_option = $this->context->cart->getDeliveryOption();

        // If some delivery options are not defined, or not valid, use the first valid option
        foreach ($delivery_option_list as $id_address => $package)
            if (!isset($cart_delivery_option[$id_address]) || !array_key_exists($cart_delivery_option[$id_address], $package))
                foreach ($package as $key => $val) {
                    $cart_delivery_option[$id_address] = $key;
                    break;
                }

        $order_list = array();
        $reference = Order::generateReference();
        $this->currentOrderReference = $reference;

        $order_creation_failed = false;
        $cart_total_paid = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(true, Cart::BOTH), 2);

        foreach ($cart_delivery_option as $id_address => $key_carriers)
            foreach ($delivery_option_list[$id_address][$key_carriers]['carrier_list'] as $id_carrier => $data)
                foreach ($data['package_list'] as $id_package) {
                    // Rewrite the id_warehouse
                    $package_list[$id_address][$id_package]['id_warehouse'] = (int)$this->context->cart->getPackageIdWarehouse($package_list[$id_address][$id_package], (int)$id_carrier);
                    $package_list[$id_address][$id_package]['id_carrier'] = $id_carrier;
                }
        // Make sure CarRule caches are empty
        CartRule::cleanCache();
        $giftWrapCounter = 1;
        foreach ($package_list as $id_address => $packageByAddress)
            foreach ($packageByAddress as $id_package => $package) {
                $order = new Order();
                $order->product_list = $package['product_list'];

                if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery') {
                    $address = new Address($id_address);
                    $this->context->country = new Country($address->id_country, $this->context->cart->id_lang);
                }

                $carrier = null;
                if (!$this->context->cart->isVirtualCart() && isset($package['id_carrier'])) {
                    $carrier = new Carrier($package['id_carrier'], $this->context->cart->id_lang);
                    $order->id_carrier = (int)$carrier->id;
                    $id_carrier = (int)$carrier->id;
                } else {
                    $order->id_carrier = 0;
                    $id_carrier = 0;
                }

                $order->id_customer = (int)$this->context->cart->id_customer;
                $order->id_address_invoice = (int)$this->context->cart->id_address_invoice;
                $order->id_address_delivery = (int)$id_address;
                $order->id_currency = $this->context->currency->id;
                $order->id_lang = (int)$this->context->cart->id_lang;
                $order->id_cart = (int)$this->context->cart->id;
                $order->reference = $reference;
                $order->id_shop = (int)$this->context->shop->id;
                $order->id_shop_group = (int)$this->context->shop->id_shop_group;

                $order->secure_key = pSQL($this->context->customer->secure_key);
                $order->payment = 'cod';
                if (isset($this->name))
                    $order->module = $this->name;
                $order->recyclable = $this->context->cart->recyclable;
                if ($giftWrapCounter == 1 && (int)$this->context->cart->gift) {
                    $order->gift = (int)$this->context->cart->gift;
                    $order->gift_message = $this->context->cart->gift_message;
                    $order->total_wrapping_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
                    $order->total_wrapping_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
                    $order->total_wrapping = $order->total_wrapping_tax_incl;
                } else {
                    $order->gift = 0;
                    $order->gift_message = null;
                    $order->total_wrapping_tax_excl = (float)abs(0);
                    $order->total_wrapping_tax_incl = (float)abs(0);
                    $order->total_wrapping = $order->total_wrapping_tax_incl;
                }

                $order->mobile_theme = $this->context->cart->mobile_theme;
                $order->conversion_rate = $this->context->currency->conversion_rate;
                $amount_paid = $this->context->cart->getOrderTotal(true, Cart::BOTH);
                ;
                $order->total_paid_real = 0;

                $order->total_products = (float)$this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS, $order->product_list, $id_carrier);
                $order->total_products_wt = (float)$this->context->cart->getOrderTotal(true, Cart::ONLY_PRODUCTS, $order->product_list, $id_carrier);

                $order->total_discounts_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_DISCOUNTS, $order->product_list, $id_carrier));
                $order->total_discounts_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_DISCOUNTS, $order->product_list, $id_carrier));
                $order->total_discounts = $order->total_discounts_tax_incl;

                $order->total_shipping_tax_excl = (float)$this->context->cart->getPackageShippingCost((int)$id_carrier, false, null, $order->product_list);
                $order->total_shipping_tax_incl = (float)$this->context->cart->getPackageShippingCost((int)$id_carrier, true, null, $order->product_list);
                $order->total_shipping = $order->total_shipping_tax_incl;

                if (!is_null($carrier) && Validate::isLoadedObject($carrier))
                    $order->carrier_tax_rate = $carrier->getTaxesRate(new Address($this->context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));

                if ($giftWrapCounter == 1) {
                    $order->total_paid_tax_excl = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(false, Cart::BOTH, $order->product_list, $id_carrier), 2);
                    $order->total_paid_tax_incl = (float)Tools::ps_round((float)$this->context->cart->getOrderTotal(true, Cart::BOTH, $order->product_list, $id_carrier), 2);
                    $order->total_paid = $order->total_paid_tax_incl;
                } else {
                    $total_wrapping_tax_excl = (float)abs($this->context->cart->getOrderTotal(false, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
                    $total_wrapping_tax_incl = (float)abs($this->context->cart->getOrderTotal(true, Cart::ONLY_WRAPPING, $order->product_list, $id_carrier));
                    $order->total_paid_tax_excl = (float)Tools::ps_round((float)($this->context->cart->getOrderTotal(false, Cart::BOTH, $order->product_list, $id_carrier) - $total_wrapping_tax_excl), 2);
                    $order->total_paid_tax_incl = (float)Tools::ps_round((float)($this->context->cart->getOrderTotal(true, Cart::BOTH, $order->product_list, $id_carrier) - $total_wrapping_tax_incl), 2);
                    $order->total_paid = $order->total_paid_tax_incl;
                }


                $order->invoice_date = '0000-00-00 00:00:00';
                $order->delivery_date = '0000-00-00 00:00:00';

                $order_list[] = $order;
                $giftWrapCounter++;

//                    // Insert new Order detail list using cart for the current order
//                    $order_detail = new OrderDetail(null, null, $this->context);
//                    $order_detail->createList($order, $this->context->cart, $id_order_state, $order->product_list, 0, true, $package_list[$id_address][$id_package]['id_warehouse']);
//                    $order_detail_list[] = $order_detail;

                // Adding an entry in order_carrier table

            }

        // The country can only change if the address used for the calculation is the delivery address, and if multi-shipping is activated
        if (Configuration::get('PS_TAX_ADDRESS_TYPE') == 'id_address_delivery')
            $this->context->country = $context_country;

        // Next !
        $only_one_gift = false;
        $cart_rule_used = array();
        $products = $this->context->cart->getProducts();
        $cart_rules = $this->context->cart->getCartRules();

        // Make sure CarRule caches are empty
        CartRule::cleanCache();
        $codStatusResultSet = array();
        $totalAdvance = 0;
        $totalAtCOD = 0;
        $error_at_cod = false;
        foreach ($order_list as $key => $order_detail) {
            $advanceOrderWise = 0;
            $productWiseArray = array();
            $countCODDisableStatus = 0;
            foreach ($order_detail->product_list as $product) {
                $price = Product::getPriceStatic((int)$product['id_product'], false, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 6, null, false, true, $product['cart_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                $price_wt = Product::getPriceStatic((int)$product['id_product'], true, ($product['id_product_attribute'] ? (int)$product['id_product_attribute'] : null), 2, null, false, true, $product['cart_quantity'], false, (int)$order->id_customer, (int)$order->id_cart, (int)$order->{Configuration::get('PS_TAX_ADDRESS_TYPE')});

                if ($price_wt >= 2000 && $price_wt <= 20000) {
                    $codStatus = true;
                } else {
                    $countCODDisableStatus++;
                    $codStatus = false;
                }

                $productWiseArray['product'][] = array('name' => $product['name'], 'quantity' => $product['cart_quantity'], 'price' => $price_wt, 'codStatus' => $codStatus);
            }

            if ($countCODDisableStatus == count($productWiseArray['product'])) {
                $advanceOrderWise = $order_detail->total_paid;

            } else {
                foreach ($productWiseArray['product'] as $row) {
                    if ($row['price'] >= 2000 && $row['price'] <= 20000) {
                        $advanceOrderWise += (750 * $row['quantity']);
                    } else {
                        $advanceOrderWise += ($row['price'] * $row['quantity']);
                    }

                }
            }
            $productWiseArray['orderTotal'] = $order_detail->total_paid;
            $productWiseArray['balanceCOD'] = $productWiseArray['orderTotal'] - $advanceOrderWise;
            if ($productWiseArray['balanceCOD'] >= 20000) {
                $advanceOrderWise = ($productWiseArray['orderTotal'] - 20000);
                $productWiseArray['balanceCOD'] = $productWiseArray['orderTotal'] - $advanceOrderWise;
            }

            $productWiseArray['advanceAmount'] = $advanceOrderWise;
            $totalAdvance += $productWiseArray['advanceAmount'];
            $totalAtCOD += $productWiseArray['balanceCOD'];
            $codStatusResultSet[] = $productWiseArray;
        }

        if (count($order_list) >= 2 && $totalAtCOD > 20000)
            $error_at_cod = true;


        $this->context->smarty->assign(array(
            'total' => $this->context->cart->getOrderTotal(true, Cart::BOTH),
            'codStatus' => $codStatusResultSet,
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
            'totalAdvance' => $totalAdvance,
            'totalAtCOD' => $totalAtCOD,
            'error_at_cod' => $error_at_cod

        ));

        $this->setTemplate('validation.tpl');
    }


}
