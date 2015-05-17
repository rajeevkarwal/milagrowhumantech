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
{if $special}
  <div class="tab-pane active" id="special">
                                                     {foreach from=$products item=product name=homebestsellerProducts}
                                                           
						  	<article class="span4 ajax_block_product">
								<div class="view view-thumb">
									<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}" alt="{$product.name|escape:html:'UTF-8'}"/></a>
									<div class="mask">
							<h2>{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}</h2>
				                        <p>{$product.description_short|strip_tags|truncate:65:'...'}</p>
				                        <a href="{$product.link}" class="info">{l s='View' mod='tdblockspecials'}</a> 
                   
                                                            {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                                            {if ($product.quantity > 0 OR $product.allow_oosp)}
                                                            <a class="exclusive ajax_add_to_cart_button info" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='tdblockspecials'}">{l s='Add to cart' mod='tdblockspecials'}</a>
                                                            {else}
                                                                <a  title="{l s='Out of Stock' mod='tdblockspecials'}">{l s='Out of Stock' mod='tdblockspecials'}</a>
                                                            {/if}
                   
                                                            {/if}
									</div>
								</div>
								<p><a href="{$product.link}">{$product.name|escape:html:'UTF-8'}</a></p>
							</article>
							{/foreach}
						  </div>
                                {else}
		<p>{l s='No product specials are available at this time.' mod='tdblockspecials'}</p>
{/if}


<!-- MODULE Block specials -->
<div id="special_block_right" class="block products_block exclusive blockspecials">
	<h4 class="title_block"><a href="{$link->getPageLink('prices-drop')}" title="{l s='Specials' mod='blockspecials'}">{l s='Specials' mod='blockspecials'}</a></h4>
	<div class="block_content">

{if $special}
		<ul class="products clearfix">
			<li class="product_image">
				<a href="{$special.link}"><img src="{$link->getImageLink($special.link_rewrite, $special.id_image, 'medium_default')}" alt="{$special.legend|escape:html:'UTF-8'}" height="{$mediumSize.height}" width="{$mediumSize.width}" title="{$special.name|escape:html:'UTF-8'}" /></a>
			</li>
			<li>
				{if !$PS_CATALOG_MODE}
					{if $special.specific_prices}
						{assign var='specific_prices' value=$special.specific_prices}
						{if $specific_prices.reduction_type == 'percentage' && ($specific_prices.from == $specific_prices.to OR ($smarty.now|date_format:'%Y-%m-%d %H:%M:%S' <= $specific_prices.to && $smarty.now|date_format:'%Y-%m-%d %H:%M:%S' >= $specific_prices.from))}
							<span class="reduction"><span>-{$specific_prices.reduction*100|floatval}%</span></span>
						{/if}
					{/if}
				{/if}

					<h5 class="s_title_block"><a href="{$special.link}" title="{$special.name|escape:html:'UTF-8'}">{$special.name|escape:html:'UTF-8'}</a></h5>
				{if !$PS_CATALOG_MODE}
					<span class="price-discount">{if !$priceDisplay}{displayWtPrice p=$special.price_without_reduction}{else}{displayWtPrice p=$priceWithoutReduction_tax_excl}{/if}</span>
					<span class="price">{if !$priceDisplay}{displayWtPrice p=$special.price}{else}{displayWtPrice p=$special.price_tax_exc}{/if}</span>
				{/if}
			</li>
		</ul>
		<p>
			<a href="{$link->getPageLink('prices-drop')}" title="{l s='All specials' mod='tdblockspecials'}">&raquo; {l s='All specials' mod='tdblockspecials'}</a>
		</p>
{else}
		<p>{l s='No product specials are available at this time.' mod='tdblockspecials'}</p>
{/if}
	</div>
</div>
<!-- /MODULE Block specials -->