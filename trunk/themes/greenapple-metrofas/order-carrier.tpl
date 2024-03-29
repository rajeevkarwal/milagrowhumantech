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
{if !$opc}
    <script type="text/javascript">
        //<![CDATA[
        var orderProcess = 'order';
        var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
        var currencyRate = '{$currencyRate|floatval}';
        var currencyFormat = '{$currencyFormat|intval}';
        var currencyBlank = '{$currencyBlank|intval}';
        var txtProduct = "{l s='Product' js=1}";
        var txtProducts = "{l s='Products' js=1}";
        var orderUrl = '{$link->getPageLink("order", true)}';

        var msg = "{l s='You must agree to the terms of service before continuing.' js=1}";
        {literal}
        function acceptCGV() {
            if ($('#cgv').length && !$('input#cgv:checked').length) {
                alert(msg);
                return false;
            }
            else
                return true;
        }
        {/literal}
        //]]>
    </script>
{else}
    <script type="text/javascript">
        var txtFree = "{l s='Free'}";
    </script>
{/if}

{if isset($virtual_cart) && !$virtual_cart && $giftAllowed && $cart->gift == 1}
    <script type="text/javascript">
        {literal}
        // <![CDATA[
        $('document').ready(function () {
            if ($('input#gift').is(':checked'))
                $('p#gift_div').show();
        });
        //]]>
        {/literal}
    </script>
{/if}

{if !$opc}
    {capture name=path}{l s='Shipping:'}{/capture}
    {include file="$tpl_dir./breadcrumb.tpl"}
{/if}


{if !$opc}
<div class="main">
<div class="main-inner">
<div class="col-main">

<div class="account-login">
<div id="carrier_area">
{else}
<div class="main">
<div class="main-inner">
<div class="col-main">
<div class="account-login">
<div id="carrier_area" class="opc-main-block">
{/if}

{if !$opc}
    <div class="page-title">

        <h1>{l s='Shipping:'}</h1>
    </div>
    <p class="cms-banner-img"><img src="/img/cms/cms-banners/cart.png" alt="milagrow-order-image"></p>
{else}
    <div class="page-title">
    <p class="cms-banner-img"><img src="/img/cms/cms-banners/cart.png" alt="milagrow-order-image"></p>
        <ol class="opc" id="checkoutSteps">
            <li id="opc-login" class="section allow">
                <div class="step-title">
                    <span class="number">2</span>

                    <h2>{l s='Delivery methods'}</h2>
                </div>
            </li>
        </ol>
    </div>
{/if}

{if !$opc}
{assign var='current_step' value='shipping'}
{include file="$tpl_dir./order-steps.tpl"}

{include file="$tpl_dir./errors.tpl"}

<form id="form" action="{$link->getPageLink('order', true, NULL, "multi-shipping={$multi_shipping}")}" method="post"
      onsubmit="return acceptCGV();">
{else}
<div id="opc_delivery_methods" class="opc-main-block">
<div id="opc_delivery_methods-overlay" class="opc-overlay" style="display: none;"></div>
{/if}

<div class="order_carrier_content">

    {if isset($virtual_cart) && $virtual_cart}
        <input id="input_virtual_carrier" class="hidden" type="hidden" name="id_carrier" value="0"/>
    {else}
        <div class="clearfix"></div>
        <div id="HOOK_BEFORECARRIER">
            {if isset($carriers) && isset($HOOK_BEFORECARRIER)}
                {$HOOK_BEFORECARRIER}
            {/if}
        </div>
        {if isset($isVirtualCart) && $isVirtualCart}
            <p class="warning">{l s='No carrier is needed for this order.'}</p>
        {else}
            {if $recyclablePackAllowed}
                <p class="checkbox">
                    <input type="checkbox" name="recyclable" id="recyclable" value="1"
                           {if $recyclable == 1}checked="checked"{/if} />
                    <label for="recyclable">{l s='I would like to receive my order in recycled packaging.'}.</label>
                </p>
            {/if}
            <div class="delivery_options_address">
                {if isset($delivery_option_list)}
                    {foreach $delivery_option_list as $id_address => $option_list}
                        <h3 class="address_heading">Choose Shipping Speed for
                            address {$address_collection[$id_address]->alias}</h3>
                        <div class="delivery_options">
                            {foreach $option_list as $key => $option}
                            {*<pre>{print_r($option)}</pre>*}
                                <div class="delivery_option item">
                                    <input class="delivery_option_radio" type="radio"
                                           name="delivery_option[{$id_address}]"
                                           onchange="{if $opc}updateCarrierSelectionAndGift();{/if}"
                                           id="delivery_option_{$id_address}_{$option@index}" value="{$key}"
                                           {if isset($delivery_option[$id_address]) && $delivery_option[$id_address] == $key}checked="checked"{/if} />
                                    <label for="delivery_option_{$id_address}_{$option@index}">
                                        <table class="resume">
                                            <tr>
                                                <td>
                                                    {*{$option.unique_carrier}*}
                                                    {*count option list{count($option_list)}*}
                                                    {if $option.unique_carrier}
                                                        <div class="name">
                                                            {foreach $option.carrier_list as $carrier}
                                                                <span class="delivery_option_title">
                                                       {if (count($option_list) == 1)}
                                                           Best Way to Deliver
                                                       {/if}
                                                       </span>
                                                            {/foreach}
                                                        </div>
                                                    {/if}
                                                    {if !$option.unique_carrier}
                                                        {if (count($option_list) == 1)}
                                                            <span class="delivery_option_title">Best Way to Deliver</span>
                                                        {/if}
                                                    {/if}
                                                    {if count($option_list) > 1}
                                                        {if $option.is_best_grade}
                                                            {if $option.is_best_price}
                                                                <div class="delivery_option_best delivery_option_icon">{l s='The best way to deliver'}
                                                                    <span class="shipping_type">
                                                                {if $option.total_price_with_tax && (!isset($free_shipping) || (isset($free_shipping) && !$free_shipping))}
                                                                    {if $use_taxes == 1}
                                                                        ({convertPrice price=$option.total_price_with_tax} {l s='(tax incl.))'}
                                                                    {else}
                                                                        ({convertPrice price=$option.total_price_without_tax} {l s='(tax excl.))'}
                                                                    {/if}
                                                                {else}
                                                                    {l s='(Free)'}
                                                                {/if}
                                                                    </span>
                                                                </div>
                                                            {else}
                                                                <div class="delivery_option_fast delivery_option_icon">{l s='The fastest way to deliver'}
                                                                    <span class="shipping_type">
                                                                {if $option.total_price_with_tax && (!isset($free_shipping) || (isset($free_shipping) && !$free_shipping))}
                                                                    {if $use_taxes == 1}
                                                                        ({convertPrice price=$option.total_price_with_tax} {l s='(tax incl.))'}
                                                                    {else}
                                                                        ({convertPrice price=$option.total_price_without_tax} {l s='(tax excl.))'}
                                                                    {/if}
                                                                {else}
                                                                    {l s='(Free)'}
                                                                {/if}
                                                                    </span>
                                                                </div>
                                                            {/if}
                                                        {else}
                                                            {if $option.is_best_price}
                                                                <div class="delivery_option_best_price delivery_option_icon">{l s='The best way to deliver'}
                                                                    <span class="shipping_type">
                                                                {if $option.total_price_with_tax && (!isset($free_shipping) || (isset($free_shipping) && !$free_shipping))}
                                                                    {if $use_taxes == 1}
                                                                        ({convertPrice price=$option.total_price_with_tax} {l s='(tax incl.))'}
                                                                    {else}
                                                                        ({convertPrice price=$option.total_price_without_tax} {l s='(tax excl.))'}
                                                                    {/if}
                                                                {else}
                                                                    {l s='(Free)'}
                                                                {/if}
                                                                    </span>
                                                                </div>
                                                            {/if}
                                                        {/if}
                                                    {/if}
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="delivery_option_carrier {if isset($delivery_option[$id_address]) && $delivery_option[$id_address] == $key}selected{/if}">
                                            {foreach $option.carrier_list as $carrier}
                                                <tr>
                                                    {if !$option.unique_carrier}
                                                        <input type="hidden" value="{$carrier.instance->id}"
                                                               name="id_carrier"/>
                                                    {/if}
                                                    <td {if $option.unique_carrier}class="first_item"
                                                        colspan="2"{/if}>
                                                        <input type="hidden" value="{$carrier.instance->id}"
                                                               name="id_carrier"/>
                                                        {if isset($carrier.instance->delay[$cookie->id_lang])}
                                                            {foreach $carrier.product_list as $product}
                                                                <span class="carrier_product_name">{$product.name}</span>
                                                                <span style="color:#d32618">({$carrier.instance->name}
                                                                    )
                                                                </span>
                                                                <br/>
                                                                {$carrier.instance->delay[$cookie->id_lang]}
                                                                <br/>
                                                            {/foreach}



                                                        {/if}
                                                    </td>
                                                </tr>
                                            {/foreach}
                                        </table>
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                        <div class="hook_extracarrier"
                             id="HOOK_EXTRACARRIER_{$id_address}">{if isset($HOOK_EXTRACARRIER_ADDR) &&  isset($HOOK_EXTRACARRIER_ADDR.$id_address)}{$HOOK_EXTRACARRIER_ADDR.$id_address}{/if}</div>
                        {foreachelse}
                        <p class="warning" id="noCarrierWarning">
                            {foreach $cart->getDeliveryAddressesWithoutCarriers(true) as $address}
                                {if empty($address->alias)}
                                    {l s='No carriers available.'}
                                {else}
                                    {l s='No carriers available for the address "%s".' sprintf=$address->alias}
                                {/if}
                                {if !$address@last}
                                    <br/>
                                {/if}
                            {/foreach}
                        </p>
                    {/foreach}
                {/if}

            </div>
            <div style="display: none;" id="extra_carrier"></div>
            {if $giftAllowed}
                <h3 class="gift_title">{l s='Gift'}</h3>
                <p class="checkbox">
                    <input type="checkbox" name="gift" id="gift" value="1"
                           {if $cart->gift == 1}checked="checked"{/if} />
                    <label for="gift">{l s='I would like my order to be gift wrapped.'} <a href="/content/34-gift-wrapping-terms?content_only=1" class="iframe">{l s='(Disclaimer/Rules)'}</a></label>
                    <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {if $gift_wrapping_price > 0}
                        ({l s='Additional cost of'}
                        <span class="price" id="gift-price">
					{if $priceDisplay == 1}{convertPrice price=$total_wrapping_tax_exc_cost}{else}{convertPrice price=$total_wrapping_cost}{/if}
				</span>
                        {if $use_taxes}{if $priceDisplay == 1} {l s='(tax excl.)'}{else} {l s='(tax incl.)'}{/if}{/if} Gift wrapping is not available for Mounts & Accessories)
                    {/if}

                </p>
                <p id="gift_div" class="textarea">
                    <label for="gift_message">{l s='If you\'d like, you can add a note to the gift:'} </label>
                    <textarea rows="5" cols="35" id="gift_message"
                              name="gift_message">{$cart->gift_message|escape:'htmlall':'UTF-8'}</textarea>
                </p>
            {/if}
        {/if}
    {/if}

    {if $conditions AND $cms_id}
        <h3 class="condition_title">{l s='Terms of service'}</h3>
        <p class="checkbox">
            <input type="checkbox" name="cgv" id="cgv" value="1" {if $checkedTOS}checked="checked"{/if} />
            <label for="cgv">{l s='I agree to the terms of service and will adhere to them unconditionally.'}</label>
            <a href="{$link_conditions}" class="iframe">{l s='(Read the Terms of Service)'}</a>
        </p>

    {/if}
    <script type="text/javascript">$('a.iframe').fancybox();</script>
</div>

{if !$opc}
<p class="cart_navigation submit">
    <input type="hidden" name="step" value="3"/>
    <input type="hidden" name="back" value="{$back}"/>
    {if !$is_guest}
        {if $back}
            <a href="{$link->getPageLink('order', true, NULL, "step=1&back={$back}&multi-shipping={$multi_shipping}")}"
               title="{l s='Previous'}" class="button left"><span><span>&laquo; {l s='Previous'}</span></span></a>
        {else}
            <a href="{$link->getPageLink('order', true, NULL, "step=1&multi-shipping={$multi_shipping}")}"
               title="{l s='Previous'}" class="button left"><span><span>&laquo; {l s='Previous'}</span></span></a>
        {/if}
    {else}
        <a href="{$link->getPageLink('order', true, NULL, "multi-shipping={$multi_shipping}")}"
           title="{l s='Previous'}" class="button left"><span><span>&laquo; {l s='Previous'}</span></span></a>
    {/if}
    {if isset($virtual_cart) && $virtual_cart || (isset($delivery_option_list) && !empty($delivery_option_list))}
        <input type="submit" name="processCarrier" value="{l s='Next'} &raquo;" class="exclusive"/>
    {/if}
</p>
</form>
{else}
<h3>{l s='Leave a message'}</h3>

<div>
    <p>{l s='If you would like to add a comment about your order, please write it in the field below.'}</p>

    <p><textarea cols="120" rows="3" name="message"
                 id="message">{if isset($oldMessage)}{$oldMessage|escape:'htmlall':'UTF-8'}{/if}</textarea></p>
</div>
</div>
{/if}
</div>
</div>
</div>

</div>
</div>


