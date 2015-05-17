{*
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
*}

{capture name=path}{l s='EMI' mod='emi'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='EMI Order Summation' mod='emi'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}


<div class="cod-content">
    <h3>{l s='EMI Payment' mod='emi'}</h3>

    <p>You have chosen EMI method to pay amount choose 3 months or 6 months </p>

    <div class="EMI_3">

        <span>3 Months EMI </span>
            <span class="pull-right">

                <form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post" id="ccAvenue_payment_form"
                      class="payment_module">
                    <input type=hidden name=Merchant_Id value="{$ccAvenue_merchant_id_3}">
                    <input type=hidden name=Amount value="{round($ccAvenue_amount_3,2)}">
                    <input type=hidden name=Order_Id value="{$ccAvenue_order_id}">
                    <input type=hidden name=Redirect_Url value="{$ccAvenue_redirect_link}">
                    <input type=hidden name=Checksum value="{$ccAvenue_checksum_3}">
                    <input type=hidden name=billing_cust_name value="{$billing_cust_name}">
                    <input type=hidden name=billing_cust_address value="{$billing_cust_address}">
                    <input type=hidden name=billing_cust_country value="{$billing_cust_country}">
                    <input type=hidden name=billing_cust_state value="{$billing_cust_state}">
                    <input type=hidden name=billing_cust_city value="{$billing_city}">
                    <input type=hidden name=billing_zip_code value="{$billing_zip}">
                    <input type=hidden name=billing_cust_tel value="{$billing_cust_tel}">
                    <input type=hidden name=billing_cust_email value="{$billing_cust_email}">

                    <input type=hidden name=delivery_cust_name value="{$delivery_cust_name}">
                    <input type=hidden name=delivery_cust_address value="{$delivery_cust_address}">
                    <input type=hidden name=delivery_cust_country value="{$delivery_cust_country}">
                    <input type=hidden name=delivery_cust_state value="{$delivery_cust_state}">
                    <input type=hidden name=delivery_cust_city value="{$delivery_city}">
                    <input type=hidden name=delivery_zip_code value="{$delivery_zip}">
                    <input type=hidden name=delivery_cust_tel value="{$delivery_cust_tel}">
                    <input type=hidden name=delivery_cust_email value="{$delivery_cust_email}">
                    <input type=hidden name=Merchant_Param value="{$merchant_param_3}">

                    <input type="submit" value="PAY NOW" name="submit" class="exclusive_large">
                </form>
            </span>


    </div>
    <div class="emi_3_description_table">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width:50%">Details</th>
                <th style="width:50%">Charges</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Total Order</td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$total}</span>
                    </span></td>
            </tr>
            <tr>
                <td>EMI Proceesing Charge ({$emi_3_processing_fee_tax}%)</td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$processing_fee_3}</span>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Service Tax 12.36% of  <span id="amount_{$currencies.0.id_currency}"
                                                 class="price">{convertPrice price=$processing_fee_3}</span>
                    </span></td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$serviceTax3Months}</span>
                    </span></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$ccAvenue_amount_3}</span>
                    </span></td>
            </tr>

            </tbody>

        </table>
    </div>
    <div class="EMI_3">

        <span>6 Months EMI </span>

        <span class="pull-right">

            <form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post" id="ccAvenue_payment_form"
                  class="payment_module">
                <input type=hidden name=Merchant_Id value="{$ccAvenue_merchant_id_6}">
                <input type=hidden name=Amount value="{round($ccAvenue_amount_6,2)}">
                <input type=hidden name=Order_Id value="{$ccAvenue_order_id}">
                <input type=hidden name=Redirect_Url value="{$ccAvenue_redirect_link}">
                <input type=hidden name=Checksum value="{$ccAvenue_checksum_6}">
                <input type=hidden name=billing_cust_name value="{$billing_cust_name}">
                <input type=hidden name=billing_cust_address value="{$billing_cust_address}">
                <input type=hidden name=billing_cust_country value="{$billing_cust_country}">
                <input type=hidden name=billing_cust_state value="{$billing_cust_state}">
                <input type=hidden name=billing_cust_city value="{$billing_city}">
                <input type=hidden name=billing_zip_code value="{$billing_zip}">
                <input type=hidden name=billing_cust_tel value="{$billing_cust_tel}">
                <input type=hidden name=billing_cust_email value="{$billing_cust_email}">

                <input type=hidden name=delivery_cust_name value="{$delivery_cust_name}">
                <input type=hidden name=delivery_cust_address value="{$delivery_cust_address}">
                <input type=hidden name=delivery_cust_country value="{$delivery_cust_country}">
                <input type=hidden name=delivery_cust_state value="{$delivery_cust_state}">
                <input type=hidden name=delivery_cust_city value="{$delivery_city}">
                <input type=hidden name=delivery_zip_code value="{$delivery_zip}">
                <input type=hidden name=delivery_cust_tel value="{$delivery_cust_tel}">
                <input type=hidden name=delivery_cust_email value="{$delivery_cust_email}">
                <input type=hidden name=Merchant_Param value="{$merchant_param_6}">

                <input type="submit" value="PAY NOW" name="submit" class="exclusive_large">
            </form>
        </span>

    </div>
    <div class="emi_6_description_table">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width:50%">Details</th>
                <th style="width:50%">Charges</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Total Order</td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$total}</span>
                    </span></td>
            </tr>
            <tr>
                <td>EMI Proceesing Charge ({$emi_6_processing_fee_tax}%)</td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$processing_fee_6}</span>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Service Tax 12.36% of  <span id="amount_{$currencies.0.id_currency}"
                                                 class="price">{convertPrice price=$processing_fee_6}</span>
                    </span></td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$serviceTax6Months}</span>
                    </span></td>
            </tr>
            <tr>
                <td>Total</td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$ccAvenue_amount_6}</span>
                    </span></td>
            </tr>


            </tbody>

        </table>
    </div>
    <p class="cart_navigation">
        <a href="{$link->getPageLink('order', true)}?step=3"
           class="button_large">{l s='Other payment methods' mod='emi'}</a>
    </p>
</div>

