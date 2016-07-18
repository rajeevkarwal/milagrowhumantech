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

{capture name=path}{l s='Cash on Delivery' mod='cod'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

{*<h2>{l s='Order summation' mod='cod'}</h2>*}


{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}
<div class="cod-content">


    <h3>{l s='Cash on delivery (COD) payment' mod='cod'}</h3>

    <p>The total amount for your order is <span
                id="amount_{$currencies.0.id_currency}" class="price">{convertPrice price=$total}</span>
        {if $use_taxes == 1}
            {l s='(tax incl.)' mod='cod'}
        {/if} </span> and you will have to pay advance amount of <span id="amount_{$currencies.0.id_currency}"
                                                                       class="price"><strong>{convertPrice price=750+$totalAdvance}</strong></span>

    </p>

    <p>

        Please note that we charge a non-refundable advance of Rs. 750/- to cover for the to and fro freight cost which
        will be adjusted in the Invoice value.
    </p>

    <p>You will have to confirm your order by clicking Pay Now button and you will be redirected to payment gateway
        to
        complete the payment process</p>


    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Payment details</th>
            <th>Amount</th>
        </tr>

        </thead>
        <tbody>
        <tr>
            <td><strong>Total Invoice Value</strong></td>
            <td><span id="amount_{$currencies.0.id_currency}"
                      class="price">{convertPrice price=$total}</span>
                </span></td>


        </tr>
        <tr>
            <td><strong>Non Refundable Advance for COD Order Processing</strong></td>
            <td><span id="amount_{$currencies.0.id_currency}"
                      class="price">{convertPrice price=750}</span>
                </span></td>
        </tr>

        {if $totalAdvance>0}
            <tr>
                <td><strong>Additional Advance Amount collected (As balance cash to be collected can not exceed Rs
                        20,000/- as per company policy)</strong></td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price">{convertPrice price=$totalAdvance}</span>
                    </span></td>
            </tr>
        {/if}


        <tr>
            <td><strong>Balance to be paid at the time of delivery</strong></td>
            <td><span id="amount_{$currencies.0.id_currency}"
                      class="price">{convertPrice price=$totalAtCOD}</span>
                </span></td>
        </tr>

        <tr>
            <td></td>
            <td>

                <form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post"
                      id="ccAvenue_payment_form"
                      class="payment_module">
                    <input type=hidden name=Merchant_Id value="{$ccAvenue_merchant_id}">
                    <input type=hidden name=Amount value="{$ccAvenue_amount}">
                    <input type=hidden name=Order_Id value="{$ccAvenue_order_id}">
                    <input type=hidden name=Redirect_Url value="{$ccAvenue_redirect_link}">
                    <input type=hidden name=Checksum value="{$ccAvenue_checksum}">
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
                    <input type="submit" value="PAY NOW" name="submit" class="exclusive_large">
                </form>
                </form>
            </td>

        </tr>
        </tbody>
    </table>

    <a href="{$link->getPageLink('order', true)}?step=3"
       class="button_large">{l s='Other payment methods' mod='cod'}</a>
</div>
<!-- Google Code for MilagrowHumantech Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968875551;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "VZV0CJnS7xEQn7z_zQM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/968875551/?label=VZV0CJnS7xEQn7z_zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

