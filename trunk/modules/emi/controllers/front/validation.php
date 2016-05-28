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
require("libFunctions.php");
class EMIValidationModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();


        //below logic change adding flat 2 % and 4% for 3 and 6 months respectively.
        $threemonthstaxperAnnum = Configuration::get('EMI_CCAVENUE_3_MONTHS_TAX');
//        $threeMonthsTax = ($threemonthstaxperAnnum / 12) * 3;
        $threeMonthsTax = $threemonthstaxperAnnum; //using flat 2 % for EMI 3 months
        $sixmonthstaxperAnnum = Configuration::get('EMI_CCAVENUE_6_MONTHS_TAX');
//        $sixMonthsTax = ($sixmonthstaxperAnnum / 12) * 6;
        $sixMonthsTax = $sixmonthstaxperAnnum; //using flat 4 % for EMI 6 Months
//        $serviceTax = 12.36;
        /*
         * dated 20-9-2015 service tax change to 14
         */
        //$serviceTax = 14;
        $serviceTax = 14.5;
        if(strtotime(date('Y-m-d'))>=strtotime(date('2016-06-01')))
            $serviceTax=15;

        $orderTotal = $this->context->cart->getOrderTotal(true, Cart::BOTH);
        $Redirect_Url = 'http://' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/emi/validation.php'; //your redirect URL where your customer will be redirected after authorisation from CCAvenue

        //making details for 3 months EMI
        $merchantid3month = Configuration::get('_MERCHANT_ID_EMI_CCAVENUE_3');
        $Order_Id = 'EMI_' . (int)$this->context->cart->id;
        $threeMonthsEMIProcessingFees = ($orderTotal * $threeMonthsTax) / 100;
        $serviceTax3Months = ($threeMonthsEMIProcessingFees * $serviceTax) / 100;
        $totalThreeMonthsAmount = $threeMonthsEMIProcessingFees + $serviceTax3Months + $orderTotal;
        $totalThreeMonthsAmount = round($totalThreeMonthsAmount, 2);

        $ThreeMonthsWorkingKey = Configuration::get('WORKING_KEY_EMI_3_MONTHS'); //put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key login to your
        $threemonthsChecksum = getChecksum($merchantid3month, $Order_Id, $totalThreeMonthsAmount, $Redirect_Url, $ThreeMonthsWorkingKey);

        //end details to be send to 3 months EMI screen

        //start making details for 6 months EMI screen
        $merchantid6month = Configuration::get('_MERCHANT_ID_EMI_CCAVENUE_6');
        $Order_Id = 'EMI_' . (int)$this->context->cart->id;
        $sixMonthsEMIProcessingFees = ($orderTotal * $sixMonthsTax) / 100;
        $serviceTax6Months = ($sixMonthsEMIProcessingFees * $serviceTax) / 100;
        $totalSixMonthsAmount = $sixMonthsEMIProcessingFees + $serviceTax6Months + $orderTotal;
        $totalSixMonthsAmount = round($totalSixMonthsAmount, 2);
        $sixMonthsWorkingKey = Configuration::get('WORKING_KEY_EMI_6_MONTHS'); //put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key login to your
        $sixmonthsChecksum = getChecksum($merchantid6month, $Order_Id, $totalSixMonthsAmount, $Redirect_Url, $sixMonthsWorkingKey);
        //end details to be send to 6 months EMI Screen

        $billing = new Address($this->context->cart->id_address_invoice);
        $billing_state = $billing->id_state ? new State($billing->id_state) : false;

        $delivery = new Address($this->context->cart->id_address_delivery);
        $delivery_state = $delivery->id_state ? new State($delivery->id_state) : false;

        //assigning data for 3 months EMI Option
        $this->context->smarty->assign(array(
            'ccAvenue_merchant_id_3' => $merchantid3month,
            'ccAvenue_checksum_3' => $threemonthsChecksum,
            'ccAvenue_order_id' => $Order_Id,
            'ccAvenue_amount_3' => $totalThreeMonthsAmount,
            'ccAvenue_redirect_link' => $Redirect_Url,
            'billing_cust_name' => $billing->firstname . '' . $billing->lastname,
            'billing_cust_address' => $billing->address1 . '' . $billing->address2,
            'billing_cust_country' => $billing->country,
            'billing_cust_state' => $billing->id_state ? $billing_state->name : '',
            'billing_city' => $billing->city,
            'billing_zip' => $billing->postcode,
            'billing_cust_tel' => ($billing->phone) ? $billing->phone : $billing->phone_mobile,
            'billing_cust_email' => $this->context->customer->email,
            'merchant_param_3' => '3_months',
            'processing_fee_3' => $threeMonthsEMIProcessingFees,
            'emi_3_processing_fee_tax' => $threeMonthsTax,
            'serviceTax3Months' => $serviceTax3Months,
            'emi3Amount' => ($totalThreeMonthsAmount / 3),
            'delivery_cust_name' => $delivery->firstname . '' . $delivery->lastname,
            'delivery_cust_address' => $delivery->address1 . '' . $delivery->address2,
            'delivery_cust_country' => $delivery->country,
            'delivery_cust_state' => $delivery->id_state ? $delivery_state->name : '',
            'delivery_city' => $delivery->city,
            'delivery_zip' => $delivery->postcode,
            'delivery_cust_tel' => ($delivery->phone) ? $delivery->phone : $delivery->phone_mobile,
            'delivery_cust_email' => $this->context->customer->email,
        ));

        //assigning data for 6 months EMI Option

        $this->context->smarty->assign(array(
            'ccAvenue_merchant_id_6' => $merchantid6month,
            'ccAvenue_checksum_6' => $sixmonthsChecksum,
            'ccAvenue_amount_6' => $totalSixMonthsAmount,
            'merchant_param_6' => '6_months',
            'processing_fee_6' => $sixMonthsEMIProcessingFees,
            'emi_6_processing_fee_tax' => $sixMonthsTax,
            'serviceTax6Months' => $serviceTax6Months,
            'emi6Amount' => ($totalSixMonthsAmount / 6)
        ));

        $this->context->smarty->assign(array(
            'total' => $this->context->cart->getOrderTotal(true, Cart::BOTH),
            'this_path' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/emi/'
        ));

        $this->setTemplate('validation.tpl');
    }

}
