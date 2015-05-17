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
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<tr id="product_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}" class="{if $productLast}last_item{elseif $productFirst}first_item{/if} {if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed == 0}alternate_item{/if} cart_item {if $odd}odd{else}even{/if}">
	<td class="item-product-img">
		<a  class="product-image" href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small_default')}" alt="{$product.name|escape:'htmlall':'UTF-8'}" {if isset($smallSize)}width="{$smallSize.width}" height="{$smallSize.height}" {/if} /></a>
	</td>
	<td class="item-product-name">
             <h2 class="product-name">
		<p class="s_title_block"><a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a></p>
		{if isset($product.attributes) && $product.attributes}<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.attributes|escape:'htmlall':'UTF-8'}</a>{/if}
	</h2>
    </td>
        
	<td class="a-center item-product-edit">{if $product.reference}{$product.reference|escape:'htmlall':'UTF-8'}{else}--{/if}</td>
	<td class="cart_quantity  a-center item-product-qty" width="75"{if isset($customizedDatas.$productId.$productAttributeId) AND $quantityDisplayed == 0} style="text-align: center;"{/if}>
	{if isset($cannotModify) AND $cannotModify == 1}
		<span style="float:left">{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}</span>
	{else}
		{if !isset($customizedDatas.$productId.$productAttributeId) OR $quantityDisplayed > 0}
                <div class="cart_quantity_button add-to-cart">
                <input rel="nofollow" type="button" class="qty-increase quantity_box_button_up cart_quantity_up " id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}" onclick="{$link->getPageLink('cart', true, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_address_delivery={$product.id_address_delivery|intval}&amp;token={$token_cart}")}" title="{l s='Add'}" />

                <input type="hidden" value="{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}" name="quantity_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}_hidden" />
                <input  type="text" autocomplete="off" class="input-text qty cartqty" style="float: left; width:1.9em!important;" value="{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}"  name="quantity_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}" />

                {if $product.minimal_quantity < ($product.cart_quantity-$quantityDisplayed) OR $product.minimal_quantity <= 1}

                <input rel="nofollow" type="button" class="qty-decrease quantity_box_button_down cart_quantity_down" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}" onclick="{$link->getPageLink('cart', true, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_address_delivery={$product.id_address_delivery|intval}&amp;op=down&amp;token={$token_cart}")}" title="{l s='Remove'}"/>
                {else}
                <input type="button"  style="opacity: 0.3;" class="qty-decrease quantity_box_button_down cart_quantity_down" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{if $quantityDisplayed > 0}nocustom{else}0{/if}_{$product.id_address_delivery|intval}" title="{l s='You must purchase a minimum of %d of this product.' sprintf=$product.minimal_quantity}" title="{l s='Remove'}"/>
                {/if}
                </div>

		{/if}
	{/if}
	</td>
	<td  class="cart_total a-right item-product-totals">
		<form method="post" action="{$link->getPageLink('cart', true, NULL, "token={$token_cart}")}">
			<input type="hidden" name="id_product" value="{$product.id_product}" />
			<input type="hidden" name="id_product_attribute" value="{$product.id_product_attribute}" />
			<select name="address_delivery" id="select_address_delivery_{$product.id_product}_{$product.id_product_attribute}_{$product.id_address_delivery|intval}" class="cart_address_delivery">
				{if $product.id_address_delivery == 0 && $delivery->id == 0}
				<option></option>
				{/if}
				<option value="-1">{l s='Create a new address'}</option>
				{foreach $address_list as $address}
					<option value="{$address.id_address}"
						{if ($product.id_address_delivery > 0 && $product.id_address_delivery == $address.id_address) || ($product.id_address_delivery == 0  && $address.id_address == $delivery->id)}
							selected="selected"
						{/if}
					>
						{$address.alias}
					</option>
				{/foreach}
				<option value="-2">{l s='Ship to multiple addresses'}</option>
			</select>
		</form>
	</td>
	<td class="cart_delete">
	</td>
</tr>