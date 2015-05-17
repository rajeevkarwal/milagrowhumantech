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

<!-- MODULE Home Featured Products -->
<h1 class="products-block-header">{l s='Featured products' mod='homefeatured'}</h1>
<div class="clear">&nbsp;</div>
<p>  
<div class="newproducts">
 {if isset($products) AND $products}
        <div class="carousel">
            {assign var='liHeight' value=250}
            {assign var='nbItemsPerLine' value=4}
            {assign var='nbLi' value=$products|@count}
            {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
            {math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight} 
            <div class="slider">
                {foreach from=$products item=product name=homeFeaturedProducts}
                {math equation="(total%perLine)" total=$smarty.foreach.homeFeaturedProducts.total perLine=$nbItemsPerLine assign=totModulo}
                {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
                <div class="ajax_block_product {if $smarty.foreach.homeFeaturedProducts.first}first{elseif $smarty.foreach.homeFeaturedProducts.last}last{else}{/if} {if $smarty.foreach.homeFeaturedProducts.iteration%$nbItemsPerLine == 0}{elseif $smarty.foreach.homeFeaturedProducts.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.homeFeaturedProducts.iteration > ($smarty.foreach.homeFeaturedProducts.total - $totModulo)}{/if} item slide"> 
                {if isset($product.new) && $product.new == 1}<div class="newproduct_grid">{l s='New' mod='homefeatured'}</div>{/if}
                    {if $product.reduction}
                                        <span id="old_price_display" style="text-decoration:line-through;">{convertPrice price=$product.price_without_reduction}</span>
                                        {/if}
            {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE} <div class="saleproduct">{l s='Sale' mod='homefeatured'}</div>{/if}
            <!-- product -->
            <div class="box-product-item">
                <div class="view-first">
                    <div class="view-content">
                        <div class="image">
                            <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_img_link">
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
                            </a>
                        </div>
                        <div class="bottom-block">
                            <div class="name">
                                <a href="{$product.link}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                            </div>

                            {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                {if ($product.quantity > 0 OR $product.allow_oosp)}

                                <a class="ajax_add_to_cart_button link-cart" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homefeatured'}">{l s='Add to cart' mod='homefeatured'}</a>
                                {else}
                                    <div class="link-cart" >{l s='Out Of Stock' mod='homefeatured'}</div>
                                {/if}
                            {/if}

               <div class="price"> 
                {if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}{else}{/if}
            </div>
        </div>
    </div>
    <div class="slide-block">
        <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
        <div class="image-rating"></div>
        <div class="btn-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;">{l s='Add to Wish List' mod='homefeatured'}</div>  
        <div class="btn-compare link-compare"  id="comparator_item_{$product.id_product}" >{l s='Add to Compare' mod='homefeatured'}</div>
    </div>
</div>
</div>
<!-- / product -->

</div>

            {/foreach} 
        </div>  

</div>
<div class="prev new-arrow">&nbsp;</div>
<div class="next new-arrow">&nbsp;</div>  
{else}
    <p>{l s='No featured products' mod='homefeatured'}</p>
{/if}
</div>  

<div class="clear"></div>
<script type="text/javascript">
    jQuery('.new-arrow.prev').addClass('disabled');
    jQuery('.carousel').iosSlider({
    desktopClickDrag: true,
    snapToChildren: true,
    infiniteSlider: false,
    navNextSelector: '.new-arrow.next',
    navPrevSelector: '.new-arrow.prev',
    lastSlideOffset: 3,
    onFirstSlideComplete: function(){
    jQuery('.new-arrow.prev').addClass('disabled');
},
onLastSlideComplete: function(){
jQuery('.new-arrow.next').addClass('disabled');
},
onSlideChange: function(){
jQuery('.new-arrow.prev').removeClass('disabled');
jQuery('.new-arrow.next').removeClass('disabled');
}
});               
</script>    
</p>

<!-- /MODULE Home Featured Products -->
