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
<div style="font-size: 8pt; color: #444;">
<!-- ADDRESSES -->
<table style="width: 100%" cellpadding="1">
    <tr>

        <td style="width:50%;text-align: left;border-left: 1px solid #333;border-top: 1px solid #333;">&nbsp;&nbsp;Milagrow
            Business
            & Knowledge Solutions (P) Ltd.
        </td>
        <td rowspan="3" align="center" valign="middle"
            style="width:25%;border-left:1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;">
            <strong>Invoice No.</strong><br>{$title|escape:'htmlall':'UTF-8'}</td>
        <td rowspan="3"
            style="width:25%;text-align:center;margin-top:50%;border-left:1px solid #333;border-top: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;">
            <strong>Invoice Date</strong><br>{$date|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>

        <td style="width:50%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;796,</td>

    </tr>
    <tr>

        <td style="width:50%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;Phase V,</td>
    </tr>
    <tr>

        <td style="width:50%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;Udyog Vihar</td>
        <td rowspan="3" align="center" valign="middle"
            style="width:25%;border-left:1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;">
            <strong>Order No.</strong><br>{$order->getUniqReference()}</td>
        <td rowspan="3"
            style="width:25%;text-align:center;margin-top:50%;border-left:1px solid #333;border-top: 1px solid #333;border-right: 1px solid #333;border-bottom: 1px solid #333;">
            <strong>Order Date</strong><br>
            {*{dateFormat date=$order->date_add}*}
            {$order->date_add|date_format:"%d-%m-%Y"}
        </td>
    </tr>
    <tr>

        <td style="width:50%;text-align: left;border-left: 1px solid #333;">&nbsp;&nbsp;Gurgaon</td>

    </tr>
    <tr>

        <td style="width:50%;text-align: left;border-left: 1px solid #333;border-bottom: 1px solid #333;">&nbsp;&nbsp;Email:
            receivables@milagrow.in
        </td>
    </tr>
    <tr>

        {if !empty($delivery_address)}
            <td style="width: 50%;padding:10px;border-left:1px solid #333;border-bottom:1px solid #333;">

                <span style="font-weight: bold; font-size: 12pt; color: #9E9F9E">{l s='Delivery Address' pdf='true'}</span><br/>
                {$delivery_address}
            </td>
            <td colspan="2"
                style="width: 50%;padding:10px;border-left:1px solid #333;border-bottom:1px solid #333;border-right:1px solid #333;">
                <span style="font-weight: bold; font-size: 12pt; color: #9E9F9E">{l s='Billing Address' pdf='true'}</span><br/>
                <span style="padding:10px;">{$invoice_address}</span>
            </td>
        {else}
            <td style="width: 50%;border-left:1px solid #333;border-bottom:1px solid #333;">

                <span style="font-weight: bold; font-size: 12pt; color: #9E9F9E">{l s='Delivery Address.' pdf='true'}</span><br/>
                {$invoice_address}


            </td>
            <td colspan="2"
                style="width: 50%;padding:10px;border-left:1px solid #333;border-bottom:1px solid #333;border-right:1px solid #333;">
                <span style="font-weight: bold; font-size: 12pt; color: #9E9F9E">{l s='Billing Address.' pdf='true'}</span><br/>
                <span style="padding:10px;">{$invoice_address}</span>
            </td>
        {/if}
    </tr>
    {*<table style="width: 100%">*}

</table>
<!-- / ADDRESSES -->

<div style="line-height: 1pt">&nbsp;</div>

<!-- PRODUCTS TAB -->
<table style="width: 100%" border="0.7">
<tr>

<td style="width: 100%;">
<table style="width: 100%; font-size: 8pt;">
    <tr style="line-height:4px;">
        <td style="text-align: left; background-color: #4D4D4D; color: #FFF;font-weight: bold; width: 6%">{l s='S.No' pdf='true'}</td>
        <td style="text-align: left; background-color: #4D4D4D; color: #FFF;font-weight: bold; width: 16%">{l s='Reference' pdf='true'}</td>
        <td style="text-align: left; background-color: #4D4D4D; color: #FFF;font-weight: bold; width: 28%">{l s='Product Details' pdf='true'}</td>
        <!-- unit price tax excluded is mandatory -->
        {if !$tax_excluded_display}
            <td style="background-color: #4D4D4D; color: #FFF; text-align: center; font-weight: bold; width: 11%">{l s='Unit Price' pdf='true'}
                <br/>{l s='(VAT Excl.)' pdf='true'}</td>
        {/if}
        <td style="background-color: #4D4D4D; color: #FFF; text-align: center; font-weight: bold; width: 10%">{l s='VAT' pdf='true'}</td>
        <td style="background-color: #4D4D4D; color: #FFF; text-align: center; font-weight: bold; width: 11%">
            {l s='Unit Price' pdf='true'}
            {if $tax_excluded_display}
                {l s='(VAT Excl.)' pdf='true'}
            {else}
                {l s='(VAT Incl.)' pdf='true'}
            {/if}
        </td>
        {*<td style="background-color: #4D4D4D; color: #FFF; text-align: right; font-weight: bold; width: 10%">{l s='Discount' pdf='true'}</td>*}

        <td style="background-color: #4D4D4D; color: #FFF; text-align: center; font-weight: bold; width: 6%">{l s='Qty' pdf='true'}</td>
        <td style="background-color: #4D4D4D; color: #FFF; text-align: center; font-weight: bold; width: {if !$tax_excluded_display}12%{else}23%{/if}">
            {l s='Total Price' pdf='true'}
            {if $tax_excluded_display}
                {l s='(VAT Excl.)' pdf='true'}
            {else}
                {l s='(VAT Incl.)' pdf='true'}
            {/if}
        </td>
    </tr>
    <!-- PRODUCTS -->
    {assign var=productCounter value=1}
    {foreach $order_details as $order_detail}
        {cycle values='#FFF,#DDD' assign=bgcolor}
        <tr style="line-height:6px;background-color:{$bgcolor};">
            <td style="text-align: left; width: 6%">{$productCounter}</td>
            <td style="text-align: left; width: 16%">{$order_detail.product_reference}</td>
            <td style="text-align: left; width: 28%">{$order_detail.name}</td>
            <!-- unit price tax excluded is mandatory -->
            {if !$tax_excluded_display}
                <td style="text-align: center; width: 11%">
                    {displayPrice currency=$order->id_currency price=$order_detail.unit_price_tax_excl}
                </td>
            {/if}
            <td style="text-align: center; width: 10%">
                {assign var=show_tax value=(($order_detail.unit_price_tax_incl-$order_detail.unit_price_tax_excl)/$order_detail.unit_price_tax_excl)*100}
                {$show_tax|round:3}%
            </td>
            <td style="text-align: center; width: 11%">
                {if $tax_excluded_display}
                    {displayPrice currency=$order->id_currency price=$order_detail.unit_price_tax_excl}
                {else}
                    {displayPrice currency=$order->id_currency price=$order_detail.unit_price_tax_incl}
                {/if}
            </td>
            {*<td style="text-align: right; width: 10%">*}
            {*{if (isset($order_detail.reduction_amount) && $order_detail.reduction_amount > 0)}*}
            {*-{displayPrice currency=$order->id_currency price=$order_detail.reduction_amount}*}
            {*{else if (isset($order_detail.reduction_percent) && $order_detail.reduction_percent > 0)}*}
            {*-{$order_detail.reduction_percent}%*}
            {*{else}*}
            {*--*}
            {*{/if}*}
            {*</td>*}
            <td style="text-align: center; width: 6%">{$order_detail.product_quantity}</td>
            <td style="text-align: center;  width: {if !$tax_excluded_display}12%{else}24%{/if}">
                {if $tax_excluded_display}
                    {displayPrice currency=$order->id_currency price=$order_detail.total_price_tax_excl}
                {else}
                    {displayPrice currency=$order->id_currency price=$order_detail.total_price_tax_incl}
                {/if}
            </td>

        </tr>
        {capture assign=productCounter}{$productCounter+1}{/capture}
        {foreach $order_detail.customizedDatas as $customizationPerAddress}
            {foreach $customizationPerAddress as $customizationId => $customization}
                <tr style="line-height:6px;background-color:{$bgcolor}; ">
                    <td style="line-height:3px; text-align: left; width: 60%; vertical-align: top">

                        <blockquote>
                            {if isset($customization.datas[$smarty.const._CUSTOMIZE_TEXTFIELD_]) && count($customization.datas[$smarty.const._CUSTOMIZE_TEXTFIELD_]) > 0}
                                {foreach $customization.datas[$smarty.const._CUSTOMIZE_TEXTFIELD_] as $customization_infos}
                                    {$customization_infos.name}: {$customization_infos.value}
                                    {if !$smarty.foreach.custo_foreach.last}
                                        <br/>
                                    {else}
                                        <div style="line-height:0.4pt">&nbsp;</div>
                                    {/if}
                                {/foreach}
                            {/if}

                            {if isset($customization.datas[$smarty.const._CUSTOMIZE_FILE_]) && count($customization.datas[$smarty.const._CUSTOMIZE_FILE_]) > 0}
                                {count($customization.datas[$smarty.const._CUSTOMIZE_FILE_])} {l s='image(s)' pdf='true'}
                            {/if}
                        </blockquote>
                    </td>
                    <td style="text-align: right; width: 15%"></td>
                    <td style="text-align: center; width: 10%; vertical-align: top">({$customization.quantity})</td>
                    <td style="width: 15%; text-align: right;"></td>
                </tr>
            {/foreach}
        {/foreach}
    {/foreach}
    <!-- END PRODUCTS -->

    {*<!-- CART RULES -->*}
    {*{assign var="shipping_discount_tax_incl" value="0"}*}
    {*{foreach $cart_rules as $cart_rule}*}
    {*{if $cart_rule.free_shipping}*}
    {*{assign var="shipping_discount_tax_incl" value=$order_invoice->total_shipping_tax_incl}*}
    {*{/if}*}
    {*{cycle values='#FFF,#DDD' assign=bgcolor}*}
    {*<tr style="line-height:6px;background-color:{$bgcolor}" text-align="left">*}
    {*<td style="line-height:3px;text-align:left;width:60%;vertical-align:top"*}
    {*colspan="{if !$tax_excluded_display}5{else}4{/if}">{$cart_rule.name}</td>*}
    {*<td>*}
    {*{if $tax_excluded_display}*}
    {*- {$cart_rule.value_tax_excl}*}
    {*{else}*}
    {*- {$cart_rule.value}*}
    {*{/if}*}
    {*</td>*}
    {*</tr>*}
    {*{/foreach}*}
    {*<!-- END CART RULES -->*}
</table>

<table style="width: 100%">
    {if (($order_invoice->total_paid_tax_incl - $order_invoice->total_paid_tax_excl) > 0)}
        <tr style="line-height:5px;">
            <td style="width: 85%; text-align: right; font-weight: bold">{l s='Product Total (VAT Excl.)' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$order_invoice->total_products}</td>
        </tr>
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='(Add) Total VAT' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=($order_invoice->total_paid_tax_incl - $order_invoice->total_paid_tax_excl)}</td>
        </tr>
        <tr style="line-height:5px;">
            <td style="width: 85%; text-align: right; font-weight: bold">{l s='Product Total (VAT Incl.)' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$order_invoice->total_products_wt}</td>
        </tr>
    {else}
        <tr style="line-height:5px;">
            <td style="width: 85%; text-align: right; font-weight: bold">{l s='Product Total' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$order_invoice->total_products}</td>
        </tr>
    {/if}
    {if $order_invoice->total_shipping_tax_incl > 0}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='(Add) Shipping Cost' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">
                {if $tax_excluded_display}
                    {displayPrice currency=$order->id_currency price=$order_invoice->total_shipping_tax_excl}
                {else}
                    {displayPrice currency=$order->id_currency price=$order_invoice->total_shipping_tax_incl}
                {/if}
            </td>
        </tr>
    {/if}

    {if $order_invoice->total_wrapping_tax_incl > 0}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='(Add) Gift Wrapping Cost' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">
                {if $tax_excluded_display}
                    {displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_excl}
                {else}
                    {displayPrice currency=$order->id_currency price=$order_invoice->total_wrapping_tax_incl}
                {/if}
            </td>
        </tr>
    {/if}

    {if $order_invoice->total_discount_tax_incl > 0}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='(Less) Discounts' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">
                -{displayPrice currency=$order->id_currency price=($order_invoice->total_discount_tax_incl + $shipping_discount_tax_incl)}</td>
        </tr>
    {/if}





    {*{if ($order_invoice->total_paid_tax_incl - $order_invoice->total_paid_tax_excl) > 0}*}
    {**}
    {*{/if}*}

    {if $order->payment eq 'COD' || $order->payment eq 'cod'}
        {assign var=down_payment value=0}
        {assign var=down_payment_counter value=0}
        {assign var=advance_amount value=0}

        {foreach from=$order_invoice->getOrderPaymentCollection() item=payment}
            {$down_payment=$down_payment+$payment->amount}
            {if $down_payment_counter<1}
                {$advance_amount=$payment->amount-750}
            {/if}
            {$down_payment_counter=$down_payment_counter+1}
        {/foreach}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='Total Invoice Value' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=($order_invoice->total_paid_tax_incl)}</td>
        </tr>
        {if $down_payment>0}
            <tr style="line-height:5px;">
                <td style="text-align: right; font-weight: bold">{l s='Non Refundable Advance for COD Order Processing' pdf='true'}</td>
                <td style="width: 15%; text-align: right;">
                    {displayPrice currency=$order->id_currency price=(750)}
                </td>
            </tr>
        {/if}
        {if $advance_amount>0}
            <tr style="line-height:5px;">
                <td style="text-align: right; font-weight: bold">{l s='Additional Advance Amount collected (As balance cash to be collected can not exceed Rs 20,000/- as per company policy)' pdf='true'}</td>
                <td style="width: 15%; text-align: right;">
                    {displayPrice currency=$order->id_currency price=($advance_amount)}
                </td>
            </tr>
        {/if}

        {if $down_payment>=0 and $down_payment != $order_invoice->total_paid_tax_incl}
            <tr style="line-height:5px;">
                <td style="text-align: right; font-weight: bold">{l s='Balance to be paid at the time of delivery' pdf='true'}</td>
                <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=($order_invoice->total_paid_tax_incl-$down_payment)}</td>
            </tr>
        {else}
            <tr style="line-height:5px;">
                <td style="text-align: right; font-weight: bold">{l s='Balance paid at the time of delivery' pdf='true'}</td>
                <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=($order_invoice->total_paid_tax_incl-750-$advance_amount)}</td>
            </tr>
        {/if}

    {elseif $order->payment eq 'Citibank EMI' || $order->payment eq 'emi'}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='Total Order' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$order_invoice->total_paid_tax_incl}</td>
        </tr>
        {foreach from=$order_invoice->getOrderPaymentCollection() item=payment}
            {assign var=EMI_TAX_RATE value=$payment->card_holder}
        {/foreach}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">(Add) EMI File Charge ({$EMI_TAX_RATE}%)</td>
            {assign var=EMI_PROCESSING_FEES value=(($order_invoice->total_paid_tax_incl*$EMI_TAX_RATE)/100)}
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$EMI_PROCESSING_FEES}</td>
        </tr>
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">(Add) Service Tax 12.36%
                of {displayPrice currency=$order->id_currency price=$EMI_PROCESSING_FEES}</td>
            {assign var=EMI_SERVICE_CHARGE_FEES value=(($EMI_PROCESSING_FEES*12.36)/100)}
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$EMI_SERVICE_CHARGE_FEES}</td>
        </tr>
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='Total Invoice Value' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=($order_invoice->total_paid_tax_incl+$EMI_PROCESSING_FEES+$EMI_SERVICE_CHARGE_FEES)}</td>
        </tr>
    {else}
        <tr style="line-height:5px;">
            <td style="text-align: right; font-weight: bold">{l s='Total Invoice Value' pdf='true'}</td>
            <td style="width: 15%; text-align: right;">{displayPrice currency=$order->id_currency price=$order_invoice->total_paid_tax_incl}</td>
        </tr>
    {/if}


</table>

</td>
</tr>
</table>
<!-- / PRODUCTS TAB -->

<div style="line-height: 1pt">&nbsp;</div>

{*{$tax_tab}*}

{if isset($order_invoice->note) && $order_invoice->note}
    <div style="line-height: 1pt">&nbsp;</div>
    <table style="width: 100%">
        <tr>
            <td style="width: 15%"></td>
            <td style="width: 85%">{$order_invoice->note|nl2br}</td>
        </tr>
    </table>
{/if}

{if isset($HOOK_DISPLAY_PDF)}
    <div style="line-height: 1pt">&nbsp;</div>
    <table style="width: 100%">
        <tr>
            <td style="width: 15%"></td>
            <td style="width: 85%">{$HOOK_DISPLAY_PDF}</td>
        </tr>
    </table>
{/if}

<table style="width: 100%" cellpadding="1">
    <tr>

        <td style="width:100%;text-align: left;border-left: 1px solid #333;border-top: 1px solid #333;border-right: 1px solid #333;">
            &nbsp;&nbsp;<strong>Company's
                VAT TIN: </strong>6071831810
        </td>
    </tr>
    <tr>

        <td style="width:100%;text-align: left;border-left: 1px solid #333;border-right: 1px solid #333;">
            &nbsp;&nbsp;<strong>Company's CST No.: </strong>6071831810
        </td>
    </tr>
    <tr>

        <td style="width:100%;text-align: left;border-left: 1px solid #333;border-right: 1px solid #333;">
            &nbsp;&nbsp;<strong>Company's Service Tax No.: </strong>AAECM9715DST001
        </td>
    </tr>
    <tr>

        <td style="width:100%;text-align: left;border-left: 1px solid #333;border-right: 1px solid #333;">
            &nbsp;&nbsp;<strong>Company's PAN No.: </strong> AAECM9715D
        </td>
    </tr>
    <tr>
        <td style="width:100%;text-align: justify;border-left: 1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;border-right: 1px solid #333;">
            &nbsp;&nbsp;<strong>Declaration</strong>
            <ul style="font-size: 7pt;padding: 0px">
                <li style="color:red;">This invoice does not certify that you have paid the money in full to either the seller or the
                    financing bank in case you have opted for payment methods other than advance/instant online payment.
                </li>
                <li>Bills must be settled immediately or/on agreed due date, failing which, the company reserves the
                    right to charge interest @24% p.a. from due date to the actual date of payment.
                </li>
                <li>Non payment / Delayed Payment may attract penal provisions under MSME Development Act, 2006.</li>
                <li>Milagrow is an MSME as per Entrepreneurs Memorandum (EM) No.060182100689 dated 06/11/2007.</li>
                <li>Any query relating to this invoice should be raised with in 3 days otherwise the invoice will be
                    deemed as accepted.
                </li>
                <li>All disputes are subject to jurisdiction of courts in Gurgaon, Haryana, India only.</li>
            </ul>

        </td>
    </tr>
</table>

</div>


