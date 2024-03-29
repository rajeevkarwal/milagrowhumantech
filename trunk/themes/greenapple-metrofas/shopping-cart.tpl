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

{capture name=path}{l s='Your shopping cart'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<div class="main">
<div class="main-inner">
<div class="col-main">
<p class="cms-banner-img"><img src="/img/cms/cms-banners/cart.png" alt="milagrow-order-image"></p>
<div class="cart">
{if isset($empty)}

{elseif $PS_CATALOG_MODE}

{else}
    <div class="page-title title-buttons">
        <h1>{l s='Shopping-cart summary'}</h1>
        <ul class="checkout-types">
            <li>
                {if !$opc}

                    {if Configuration::get('PS_ALLOW_MULTISHIPPING')}
                        <button onclick="window.location='{if $back}{$link->getPageLink('order', true, NULL, 'step=1&amp;back={$back}')}{else}{$link->getPageLink('order', true, NULL, 'step=1')}{/if}&amp;multi-shipping=1';"
                                class="button btn-proceed-checkout btn-checkout" title="{l s='Proceed to Checkout'}"
                                type="button"><span><span>{l s='Proceed to Checkout'}</span></span></button>
                    {else}
                        <button onclick="window.location='{if $back}{$link->getPageLink('order', true, NULL, 'step=1&amp;back={$back}')}{else}{$link->getPageLink('order', true, NULL, 'step=1')}{/if}';"
                                class="button btn-proceed-checkout btn-checkout" title="{l s='Proceed to Checkout'}"
                                type="button"><span><span>{l s='Proceed to Checkout'}</span></span></button>
                    {/if}

                {/if}
            </li>
        </ul>
    </div>
    <ul class="messages">
        <li class="success-msg">
            <ul>
                <li>
                            <span>
                                <p>{l s='Your shopping cart contains:'} <span
                                            id="summary_products_quantity">{$productNumber} {if $productNumber == 1}{l s='product'}{else}{l s='products'}{/if}</span>
                                </p>
                            </span>
                </li>
            </ul>
        </li>
    </ul>
{/if}
{if isset($account_created)}
    <p class="success">
        {l s='Your account has been created.'}
    </p>
{/if}
{assign var='current_step' value='summary'}
{include file="$tpl_dir./order-steps.tpl"}
<div class="clearer"></div>
{include file="$tpl_dir./errors.tpl"}

{if isset($empty)}
<p class="warning">{l s='Your shopping cart is empty.'}</p>
{elseif $PS_CATALOG_MODE}
<p class="warning">{l s='This store has not accepted your new order.'}</p>
{else}
<script type="text/javascript">
    // <![CDATA[
    var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
    var currencyRate = '{$currencyRate|floatval}';
    var currencyFormat = '{$currencyFormat|intval}';
    var currencyBlank = '{$currencyBlank|intval}';
    var txtProduct = "{l s='product' js=1}";
    var txtProducts = "{l s='products' js=1}";
    var deliveryAddress = {$cart->id_address_delivery|intval};
    // ]]>
</script>
<div class="clear"></div>


<fieldset>
<p style="display:none" id="emptyCartWarning" class="warning">{l s='Your shopping cart is empty.'}</p>
{if isset($lastProductAdded) AND $lastProductAdded}
    <div class="cart_last_product">
        <div class="cart_last_product_header">
            <div class="left">{l s='Last product added'}</div>
        </div>
        <a class="cart_last_product_img"
           href="{$link->getProductLink($lastProductAdded.id_product, $lastProductAdded.link_rewrite, $lastProductAdded.category, null, null, $lastProductAdded.id_shop)|escape:'htmlall':'UTF-8'}"><img
                    src="{$link->getImageLink($lastProductAdded.link_rewrite, $lastProductAdded.id_image, 'small_default')}"
                    alt="{$lastProductAdded.name|escape:'htmlall':'UTF-8'}"/></a>

        <div class="cart_last_product_content">
            <p class="s_title_block"><a
                        href="{$link->getProductLink($lastProductAdded.id_product, $lastProductAdded.link_rewrite, $lastProductAdded.category, null, null, null, $lastProductAdded.id_product_attribute)|escape:'htmlall':'UTF-8'}">{$lastProductAdded.name|escape:'htmlall':'UTF-8'}</a>
            </p>
            {*{if isset($lastProductAdded.attributes) && $lastProductAdded.attributes}<a*}
                {*href="{$link->getProductLink($lastProductAdded.id_product, $lastProductAdded.link_rewrite, $lastProductAdded.category, null, null, null, $lastProductAdded.id_product_attribute)|escape:'htmlall':'UTF-8'}">{$lastProductAdded.attributes|escape:'htmlall':'UTF-8'}</a>{/if}*}
        </div>
        <br class="clear"/>
    </div>
{/if}
<div id="order-detail-content">
<table id="shopping-cart-table" class="data-table cart-table">
<col width="1"/>
<col/>
<col width="1"/>
<col width="1"/>
<col width="1"/>
<col width="1"/>
<col width="1"/>

<thead>
<tr>
    <th class="item-product-img" rowspan="1">{l s='Product'}</th>
    <th class="item-product-name" rowspan="1"><span class="nobr">{l s='Description'}</span></th>
    <th class="item-product-edit" rowspan="1">{l s='Ref.'}</th>
    <th class="a-center item-product-price" colspan="1"><span class="nobr">{l s='Unit price'}</span></th>
    <th rowspan="1" class="a-center item-product-qty">{l s='Qty'}</th>
    <th class="a-center item-product-totals" colspan="1">{l s='Total'}</th>
    <th rowspan="1" class="a-center item-product-delete">&nbsp;</th>
</tr>
</thead>

<tfoot>
<tr class="first">
    <td colspan="50" class="a-right">
        <button type="button" title="Continue Shopping" class="button btn-continue"
                onclick="window.location=('{if (isset($smarty.server.HTTP_REFERER) && strstr($smarty.server.HTTP_REFERER, 'order.php')) || isset($smarty.server.HTTP_REFERER) && strstr($smarty.server.HTTP_REFERER, 'order-opc') || !isset($smarty.server.HTTP_REFERER)}{$link->getPageLink('index')}{else}{$smarty.server.HTTP_REFERER|escape:'htmlall':'UTF-8'|secureReferrer}{/if}')"
                title="{l s='Continue shopping'}">
            <span><span>{l s='Continue shopping'}</span></span>
        </button>
        {if !$opc}
            {if Configuration::get('PS_ALLOW_MULTISHIPPING')}
                <button onclick="window.location=('{if $back}{$link->getPageLink('order', true, NULL, 'step=1&amp;back={$back}')}{else}{$link->getPageLink('order', true, NULL, 'step=1')}{/if}&amp;multi-shipping=1')"
                        type="button" title="{l s='Next'}" class="button btn-update">
                                                <span>
                                                    <span>{l s='Next'}</span>
                                                </span>
                </button>
            {else}
                <button type="submit"
                        onclick="window.location=('{if $back}{$link->getPageLink('order', true, NULL, 'step=1&amp;back={$back}')}{else}{$link->getPageLink('order', true, NULL, 'step=1')}{/if}')"
                        title="{l s='Update Shopping Cart'}" class="button btn-update">
                                                <span>
                                                    <span>{l s='Next'}</span>
                                                </span>
                </button>
            {/if}
        {/if}

    </td>
</tr>
{if $use_taxes}
    {if $priceDisplay}
        <tr class="cart_total_price">
            <td colspan="5">{if $display_tax_label}{l s='Total products (tax excl.)'}{else}{l s='Total products'}{/if}</td>
            <td colspan="2" class="price" id="total_product">{displayPrice price=$total_products}</td>
        </tr>
    {else}
        <tr class="cart_total_price">
            <td colspan="5">{if $display_tax_label}{l s='Total products (tax incl.)'}{else}{l s='Total products'}{/if}</td>
            <td colspan="2" class="price" id="total_product">{displayPrice price=$total_products_wt}</td>
        </tr>
    {/if}
{else}
    <tr class="cart_total_price">
        <td colspan="5">{l s='Total products'}</td>
        <td colspan="2" class="price" id="total_product">{displayPrice price=$total_products}</td>
    </tr>
{/if}
<tr{if $total_wrapping == 0} style="display: none;"{/if}>
    <td colspan="5">
        {if $use_taxes}
            {if $display_tax_label}{l s='Total gift wrapping (tax incl.):'}{else}{l s='Total gift-wrapping cost:'}{/if}
        {else}
            {l s='Total gift-wrapping cost:'}
        {/if}
    </td>
    <td colspan="2" class="price-discount price" id="total_wrapping">
        {if $use_taxes}
            {if $priceDisplay}
                {displayPrice price=$total_wrapping_tax_exc}
            {else}
                {displayPrice price=$total_wrapping}
            {/if}
        {else}
            {displayPrice price=$total_wrapping_tax_exc}
        {/if}
    </td>
</tr>
{if $total_shipping_tax_exc <= 0 && !isset($virtualCart)}
    <tr class="cart_total_delivery" style="{if !isset($carrier->id) || is_null($carrier->id)}display:none;{/if}">
        <td colspan="5">{l s='Shipping'}</td>
        <td colspan="2" class="price" id="total_shipping">{l s='Free Shipping!'}</td>
    </tr>
{else}
    {if $use_taxes}
        {if $priceDisplay}
            <tr class="cart_total_delivery" {if $total_shipping_tax_exc <= 0} style="display:none;"{/if}>
                <td colspan="5">{if $display_tax_label}{l s='Total shipping (tax excl.)'}{else}{l s='Total shipping'}{/if}</td>
                <td colspan="2" class="price" id="total_shipping">{displayPrice price=$total_shipping_tax_exc}</td>
            </tr>
        {else}
            <tr class="cart_total_delivery"{if $total_shipping <= 0} style="display:none;"{/if}>
                <td colspan="5">{if $display_tax_label}{l s='Total shipping (tax incl.)'}{else}{l s='Total shipping'}{/if}</td>
                <td colspan="2" class="price" id="total_shipping">{displayPrice price=$total_shipping}</td>
            </tr>
        {/if}
    {else}
        <tr class="cart_total_delivery"{if $total_shipping_tax_exc <= 0} style="display:none;"{/if}>
            <td colspan="5">{l s='Total shipping'}</td>
            <td colspan="2" class="price" id="total_shipping">{displayPrice price=$total_shipping_tax_exc}</td>
        </tr>
    {/if}
{/if}
<tr class="cart_total_voucher" {if $total_discounts == 0}style="display:none"{/if}>
    <td colspan="5">
        {if $display_tax_label}
            {if $use_taxes && $priceDisplay == 0}
                {l s='Total vouchers (tax incl.):'}
            {else}
                {l s='Total vouchers (tax excl.)'}
            {/if}
        {else}
            {l s='Total vouchers'}
        {/if}
    </td>
    <td colspan="2" class="price-discount price" id="total_discount">
        {if $use_taxes && $priceDisplay == 0}
            {assign var='total_discounts_negative' value=$total_discounts * -1}
        {else}
            {assign var='total_discounts_negative' value=$total_discounts_tax_exc * -1}
        {/if}
        {displayPrice price=$total_discounts_negative}
    </td>
</tr>
{if $use_taxes && $show_taxes}
    <tr class="cart_total_price">
        <td colspan="5">{l s='Total (tax excl.)'}</td>
        <td colspan="2" class="price" id="total_price_without_tax">{displayPrice price=$total_price_without_tax}</td>
    </tr>
    <tr class="cart_total_tax">
        <td colspan="5">{l s='Total tax'}</td>
        <td colspan="2" class="price" id="total_tax">{displayPrice price=$total_tax}</td>
    </tr>
{/if}
<tr class="cart_total_price">
    <td colspan="5" id="cart_voucher" class="cart_voucher">
        {*{if $voucherAllowed}*}
        {*{if isset($errors_discount) && $errors_discount}*}
        {*<ul class="error">*}
        {*{foreach $errors_discount as $k=>$error}*}
        {*<li>{$error|escape:'htmlall':'UTF-8'}</li>*}
        {*{/foreach}*}
        {*</ul>*}
        {*{/if}*}

        {*{/if}*}
        <div>
            {if $voucherAllowed}

            {if isset($errors_discount) && $errors_discount}
                <ul class="error">

                    {foreach $errors_discount as $k=>$error}
                        <li>{$error|escape:'htmlall':'UTF-8'}</li>
                    {/foreach}

                </ul>
            {/if}

            <form action="{if $opc}{$link->getPageLink('order-opc', true)}{else}{$link->getPageLink('order', true)}{/if}"
                  method="post" id="voucher">

                <div class="discount">

                    <h2>{l s='Gift/Loyality/Discount Coupon'}</h2>

                    <div class="discount-form">

                        <label for="coupon_code">{l s='Enter your coupon code if you have one.'}</label>

                        <div class="input-box">

                            <input type="text" class="input-text" id="discount_name" name="discount_name"
                                   value="{if isset($discount_name) && $discount_name}{$discount_name}{/if}"/>

                        </div>

                        <div class="buttons-set">

                            <p class="submit"><input type="hidden" name="submitDiscount"/>

                                <button type="submit" name="submitAddDiscount" value="" class="button">
                                    <span><span>{l s='Apply'}</span></span></button>

                            </p>

                        </div>

                        {if $displayVouchers}
                            <h4 class="title_offers">{l s='Take advantage of our offers:'}</h4>
                            <div id="display_cart_vouchers">

                                {foreach $displayVouchers as $voucher}
                                    <span onclick="$('#discount_name').val('{$voucher.name}');return false;"
                                          class="voucher_name">{$voucher.name}</span>
                                    - {$voucher.description}
                                    <br/>
                                {/foreach}

                            </div>
                        {/if}

</fieldset>


</div>

</div>
</form>
{/if}
</div>

</td>
{if $use_taxes}
    <td colspan="2" class="price total_price_container" id="total_price_container">
        <p>{l s='Total'}</p>
        <span id="total_price">{displayPrice price=$total_price}</span>
    </td>
{else}
    <td colspan="2" class="price total_price_container" id="total_price_container">
        <p>{l s='Total'}</p>
        <span id="total_price">{displayPrice price=$total_price_without_tax}</span>
    </td>
{/if}
</tr>

</tfoot>
<tbody>
{foreach $products as $product}
    {assign var='productId' value=$product.id_product}
    {assign var='productAttributeId' value=$product.id_product_attribute}
    {assign var='quantityDisplayed' value=0}
    {assign var='odd' value=$product@iteration%2}
    {assign var='ignoreProductLast' value=isset($customizedDatas.$productId.$productAttributeId) || count($gift_products)}
{* Display the product line *}
    {include file="./shopping-cart-product-line.tpl" productLast=$product@last productFirst=$product@first}
{* Then the customized datas ones*}
    {if isset($customizedDatas.$productId.$productAttributeId)}
        {foreach $customizedDatas.$productId.$productAttributeId[$product.id_address_delivery] as $id_customization=>$customization}
            <tr id="product_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"
                class="product_customization_for_{$product.id_product}_{$product.id_product_attribute}_{$product.id_address_delivery|intval}{if $odd} odd{else} even{/if} customization alternate_item {if $product@last && $customization@last && !count($gift_products)}last_item{/if}">
                <td></td>
                <td colspan="3">
                    {foreach $customization.datas as $type => $custom_data}
                        {if $type == $CUSTOMIZE_FILE}
                            <div class="customizationUploaded">
                                <ul class="customizationUploaded">
                                    {foreach $custom_data as $picture}
                                        <li><img src="{$pic_dir}{$picture.value}_small" alt=""
                                                 class="customizationUploaded"/></li>
                                    {/foreach}
                                </ul>
                            </div>
                        {elseif $type == $CUSTOMIZE_TEXTFIELD}
                            <ul class="typedText">
                                {foreach $custom_data as $textField}
                                    <li>
                                        {if $textField.name}
                                            {$textField.name}
                                        {else}
                                            {l s='Text #'}{$textField@index+1}
                                        {/if}
                                        {l s=':'} {$textField.value}
                                    </li>
                                {/foreach}

                            </ul>
                        {/if}

                    {/foreach}
                </td>
                <td class="cart_quantity" colspan="2">
                    {if isset($cannotModify) AND $cannotModify == 1}
                        <span style="float:left">{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}</span>
                    {else}
                        <div class="cart_quantity_button add-to-cart">
                            <input rel="nofollow" type="button"
                                   class="quantity_box_button_up cart_quantity_up qty-increase"
                                   id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}"
                                   onclick="{$link->getPageLink('cart', true, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_address_delivery={$product.id_address_delivery|intval}&amp;token={$token_cart}")}"
                                   title="{l s='Add'}"/>

                            <input type="hidden"
                                   value="{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}"
                                   name="quantity_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}_hidden"/>
                            <input size="2" type="text" autocomplete="off" class="cart_quantity_input"
                                   value="{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}"
                                   name="quantity_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}"/>

                            {if $product.minimal_quantity < ($product.cart_quantity-$quantityDisplayed) OR $product.minimal_quantity <= 1}
                                <input rel="nofollow" type="button"
                                       class="quantity_box_button_down cart_quantity_down qty-decrease"
                                       id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}"
                                       onclick="{$link->getPageLink('cart', true, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_address_delivery={$product.id_address_delivery|intval}&amp;op=down&amp;token={$token_cart}")}"
                                       title="{l s='Remove'}"/>
                            {else}
                                <input type="button" style="opacity: 0.3;"
                                       class="quantity_box_button_down cart_quantity_down qty-decrease"
                                       id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}"
                                       title="{l s='You must purchase a minimum of %d of this product.' sprintf=$product.minimal_quantity}"
                                       title="{l s='Remove'}"/>
                            {/if}
                        </div>
                    {/if}
                </td>
                <td class="cart_delete">
                    {if isset($cannotModify) AND $cannotModify == 1}
                    {else}
                        <div>
                            <a rel="nofollow" class="cart_quantity_delete"
                               id="{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"
                               href="{$link->getPageLink('cart', true, NULL, "delete=1&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;id_address_delivery={$product.id_address_delivery}&amp;token={$token_cart}")}">{l s='Delete'}</a>
                        </div>
                    {/if}
                </td>
            </tr>
            {assign var='quantityDisplayed' value=$quantityDisplayed+$customization.quantity}
        {/foreach}
    {* If it exists also some uncustomized products *}
        {if $product.quantity-$quantityDisplayed > 0}{include file="./shopping-cart-product-line.tpl" productLast=$product@last productFirst=$product@first}{/if}
    {/if}
{/foreach}
{assign var='last_was_odd' value=$product@iteration%2}
{foreach $gift_products as $product}
    {assign var='productId' value=$product.id_product}
    {assign var='productAttributeId' value=$product.id_product_attribute}
    {assign var='quantityDisplayed' value=0}
    {assign var='odd' value=($product@iteration+$last_was_odd)%2}
    {assign var='ignoreProductLast' value=isset($customizedDatas.$productId.$productAttributeId)}
    {assign var='cannotModify' value=1}
{* Display the gift product line *}
    {include file="./shopping-cart-product-line.tpl" productLast=$product@last productFirst=$product@first}
{/foreach}
</tbody>
{if sizeof($discounts)}
    <tbody>
    {foreach $discounts as $discount}
        <tr class="cart_discount {if $discount@last}last_item{elseif $discount@first}first_item{else}item{/if}"
            id="cart_discount_{$discount.id_discount}">
            <td class="cart_discount_name" colspan="3">{$discount.name}</td>
            <td class="cart_discount_price"><span class="price-discount">
                            {if !$priceDisplay}{displayPrice price=$discount.value_real*-1}{else}{displayPrice price=$discount.value_tax_exc*-1}{/if}
                        </span></td>
            <td class="cart_discount_delete">1</td>
            <td class="cart_discount_price">
                <span class="price-discount price">{if !$priceDisplay}{displayPrice price=$discount.value_real*-1}{else}{displayPrice price=$discount.value_tax_exc*-1}{/if}</span>
            </td>
            <td class="price_discount_del">
                {if strlen($discount.code)}<a
                    href="{if $opc}{$link->getPageLink('order-opc', true)}{else}{$link->getPageLink('order', true)}{/if}?deleteDiscount={$discount.id_discount}"
                    class="price_discount_delete" title="{l s='Delete'}">{l s='Delete'}</a>{/if}
            </td>
        </tr>
    {/foreach}
    </tbody>
{/if}
</table>
</div>

    {if $show_option_allow_separate_package}
        <p>
            <input type="checkbox" name="allow_seperated_package" id="allow_seperated_package"
                   {if $cart->allow_seperated_package}checked="checked"{/if} />
            <label for="allow_seperated_package">{l s='Send available products first'}</label>
        </p>
    {/if}
    {if !$opc}
        {if Configuration::get('PS_ALLOW_MULTISHIPPING')}
            <p>
                <input type="checkbox" {if $multi_shipping}checked="checked"{/if} id="enable-multishipping"/>
                <label for="enable-multishipping">{l s='I would like to specify a delivery address for each individual product.'}</label>
            </p>
        {/if}
    {/if}

    </fieldset>


    <div class="cart-collaterals row-fluid">

        <div class="col-1 span4">
            {*<div id="HOOK_SHOPPING_CART">{$HOOK_SHOPPING_CART}</div>*}
        </div>
        <div class="col-2 span4">

            {*{if $voucherAllowed}*}

            {*{if isset($errors_discount) && $errors_discount}*}

            {*<ul class="error">*}

            {*{foreach $errors_discount as $k=>$error}*}

            {*<li>{$error|escape:'htmlall':'UTF-8'}</li>*}

            {*{/foreach}*}

            {*</ul>*}

            {*{/if}*}

            {*<form action="{if $opc}{$link->getPageLink('order-opc', true)}{else}{$link->getPageLink('order', true)}{/if}" method="post" id="voucher">*}

            {*<div class="discount">*}

            {*<h2>{l s='Gift/Discount Coupon'}</h2>*}

            {*<div class="discount-form">*}

            {*<label for="coupon_code">{l s='Enter your coupon code if you have one.'}</label>*}

            {*<div class="input-box">*}

            {*<input type="text" class="input-text" id="discount_name" name="discount_name" value="{if isset($discount_name) && $discount_name}{$discount_name}{/if}" />*}

            {*</div>*}

            {*<div class="buttons-set">*}

            {*<p class="submit"><input type="hidden" name="submitDiscount" />*}

            {*<button  type="submit" name="submitAddDiscount" value="" class="button" ><span><span>{l s='Apply'}</span></span></button>*}

            {*</p>*}

            {*</div>*}

            {*{if $displayVouchers}*}

            {*<h4 class="title_offers">{l s='Take advantage of our offers:'}</h4>*}

            {*<div id="display_cart_vouchers">*}

            {*{foreach $displayVouchers as $voucher}*}

            {*<span onclick="$('#discount_name').val('{$voucher.name}');return false;" class="voucher_name">{$voucher.name}</span> - {$voucher.description} <br />*}

            {*{/foreach}*}

            {*</div>*}

            {*{/if}*}

            {*</fieldset>*}



            {*</div>*}

            {*</div>*}
            {*</form>*}
            {*{/if}              *}


        </div>

        <div class="totals span4">

            <table id="shopping-cart-totals-table">

                <colgroup>
                    <col>

                    <col width="1">

                </colgroup>
                <tfoot>

                <tr class="cart_total_price">


                    {if $use_taxes}
                        <td colspan="1" class="a-right" id="total_price_container" style="">
                            <strong>{l s='Grand Total'}</strong>
                        </td>
                        <td class="a-right" style="">
                            <strong><span class="price"
                                          id="total_price_button">{displayPrice price=$total_price}</span></strong>

                        </td>
                    {else}
                        <td colspan="1" class=" a-right" id="total_price_container" style="">

                            <strong>{l s='Grand Total'}</strong>

                            <strong><span class="price"
                                          id="total_price_button">{displayPrice price=$total_price}</span></strong>

                        </td>
                    {/if}

                </tr>


                </tfoot>

            </table>

            <ul class="checkout-types a-right">

                <li>

                    {if !$opc}

                        {if Configuration::get('PS_ALLOW_MULTISHIPPING')}
                            <button onclick="window.location='{if $back}{$link->getPageLink('order', true, NULL, 'step=1&amp;back={$back}')}{else}{$link->getPageLink('order', true, NULL, 'step=1')}{/if}&amp;multi-shipping=1';"
                                    class="button btn-proceed-checkout btn-checkout multishipping-button multishipping-checkout "
                                    title="{l s='Proceed to Checkout'}" type="button">
                                <span><span>{l s='Proceed to Checkout'}</span></span></button>
                        {else}
                            <button onclick="window.location='{if $back}{$link->getPageLink('order', true, NULL, 'step=1&amp;back={$back}')}{else}{$link->getPageLink('order', true, NULL, 'step=1')}{/if}';"
                                    class="button btn-proceed-checkout btn-checkout" title="{l s='Proceed to Checkout'}"
                                    type="button"><span><span>{l s='Proceed to Checkout'}</span></span></button>
                        {/if}

                    {/if}

                </li>

            </ul>

        </div>


    </div>


{* Define the style if it doesn't exist in the PrestaShop version*}
{* Will be deleted for 1.5 version and more *}
{if !isset($addresses_style)}
    {$addresses_style.company = 'address_company'}
    {$addresses_style.vat_number = 'address_company'}
    {$addresses_style.firstname = 'address_name'}
    {$addresses_style.lastname = 'address_name'}
    {$addresses_style.address1 = 'address_address1'}
    {$addresses_style.address2 = 'address_address2'}
    {$addresses_style.city = 'address_city'}
    {$addresses_style.country = 'address_country'}
    {$addresses_style.phone = 'address_phone'}
    {$addresses_style.phone_mobile = 'address_phone_mobile'}
    {$addresses_style.alias = 'address_title'}
{/if}

    {if ((!empty($delivery_option) AND !isset($virtualCart)) OR $delivery->id OR $invoice->id) AND !$opc}
        <div class="order_delivery clearfix">
            {if !isset($formattedAddresses) || (count($formattedAddresses.invoice) == 0 && count($formattedAddresses.delivery) == 0) || (count($formattedAddresses.invoice.formated) == 0 && count($formattedAddresses.delivery.formated) == 0)}
                {if $delivery->id}
                    <ul id="delivery_address" class="address item">
                        <li class="address_title">{l s='Delivery address'}&nbsp;<span
                                    class="address_alias">({$delivery->alias})</span></li>
                        {if $delivery->company}
                            <li class="address_company">{$delivery->company|escape:'htmlall':'UTF-8'}</li>{/if}
                        <li class="address_name">{$delivery->firstname|escape:'htmlall':'UTF-8'} {$delivery->lastname|escape:'htmlall':'UTF-8'}</li>
                        <li class="address_address1">{$delivery->address1|escape:'htmlall':'UTF-8'}</li>
                        {if $delivery->address2}
                            <li class="address_address2">{$delivery->address2|escape:'htmlall':'UTF-8'}</li>{/if}
                        <li class="address_city">{$delivery->postcode|escape:'htmlall':'UTF-8'} {$delivery->city|escape:'htmlall':'UTF-8'}</li>
                        <li class="address_country">{$delivery->country|escape:'htmlall':'UTF-8'} {if $delivery_state}({$delivery_state|escape:'htmlall':'UTF-8'}){/if}</li>
                    </ul>
                {/if}
                {if $invoice->id}
                    <ul id="invoice_address" class="address alternate_item">
                        <li class="address_title">{l s='Billing address'}&nbsp;<span
                                    class="address_alias">({$invoice->alias})</span></li>
                        {if $invoice->company}
                            <li class="address_company">{$invoice->company|escape:'htmlall':'UTF-8'}</li>{/if}
                        <li class="address_name">{$invoice->firstname|escape:'htmlall':'UTF-8'} {$invoice->lastname|escape:'htmlall':'UTF-8'}</li>
                        <li class="address_address1">{$invoice->address1|escape:'htmlall':'UTF-8'}</li>
                        {if $invoice->address2}
                            <li class="address_address2">{$invoice->address2|escape:'htmlall':'UTF-8'}</li>{/if}
                        <li class="address_city">{$invoice->postcode|escape:'htmlall':'UTF-8'} {$invoice->city|escape:'htmlall':'UTF-8'}</li>
                        <li class="address_country">{$invoice->country|escape:'htmlall':'UTF-8'} {if $invoice_state}({$invoice_state|escape:'htmlall':'UTF-8'}){/if}</li>
                    </ul>
                {/if}
            {else}
                {foreach from=$formattedAddresses key=k item=address}
                    <ul class="address {if $address@last}last_item{elseif $address@first}first_item{/if} {if $address@index % 2}alternate_item{else}item{/if}">
                        <li class="address_title">{if $k eq 'invoice'}{l s='Billing address'}{elseif $k eq 'delivery' && $delivery->id}{l s='Delivery address'}{/if}{if isset($address.object.alias)}&nbsp;
                                <span class="address_alias">({$address.object.alias})</span>{/if}</li>
                        {foreach $address.ordered as $pattern}
                            {assign var=addressKey value=" "|explode:$pattern}
                            <li>
                                {foreach $addressKey as $key}
                                    <span class="{if isset($addresses_style[$key])}{$addresses_style[$key]}{/if}">
                            {if isset($address.formated[$key])}
                                {$address.formated[$key]|escape:'htmlall':'UTF-8'}
                            {/if}
                        </span>
                                {/foreach}
                            </li>
                        {/foreach}
                    </ul>
                {/foreach}
                <br class="clear"/>
            {/if}
        </div>
    {/if}


    {if !empty($HOOK_SHOPPING_CART_EXTRA)}
        <div class="clear"></div>
        <div class="cart_navigation_extra">
            <div id="HOOK_SHOPPING_CART_EXTRA">{$HOOK_SHOPPING_CART_EXTRA}</div>
        </div>
    {/if}
{/if}


</div>
</div>
</div>
</div>

<!-- END page -->
