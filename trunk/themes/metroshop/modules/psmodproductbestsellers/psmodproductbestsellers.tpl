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

<!-- MODULE Block best sellers -->

<h5 class="upsell-product-h5"><a href="{$link->getPageLink('best-sales')}">{l s='Bestsellers' mod='psmodproductbestsellers'}</a></h5>
<div class="box-up-sell-wrapper">
    <div class="box-collateral box-up-sell clearfix">
        {if $best_sellers|@count > 0}
            <div class="slider">
                {foreach from=$best_sellers item=product name=myLoop}
                    <div class="{if $smarty.foreach.myLoop.first}{elseif $smarty.foreach.myLoop.last}{else}{/if} item slide"> 
                        <div class="box-product-item">
                            <div class="box-product-buttons">
                                <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                                <div class="buttons-compare link-compare"  id="comparator_item_{$product.id_product}" ></div>
                                <div class="buttons-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"></div>   
                            </div>
                            <div class="box-line"></div>
                            <div class="view-first">

                                <div class="view-content">

                                    <div class="image">
                                        <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_img_link">
                                            <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
                                        </a>
                                    </div>
                                    <div class="name">
                                        <a href="{$product.link}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                                    </div>
                                    <a class="exclusive ajax_add_to_cart_button buttons-cart" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='psmodproductbestsellers'}"></a> 
                                    <div class="price">
                                        {$product.price}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                {/foreach}
            </div>

        {else}
            <p>{l s='No best sellers at this time' mod='psmodproductbestsellers'}</p>
        {/if}

    </div>
    <div class="prev upsell-arrow" box-up-sell></div>
    <div class="next upsell-arrow"></div>
</div>
<script type="text/javascript">
    jQuery('.upsell-arrow.prev').addClass('disabled');
    jQuery('.box-up-sell').iosSlider({
    desktopClickDrag: true,
    snapToChildren: true,
    infiniteSlider: false,
    navNextSelector: '.upsell-arrow.next',
    navPrevSelector: '.upsell-arrow.prev',

    onFirstSlideComplete: function(){
    jQuery('.upsell-arrow.prev').addClass('disabled');
},
onLastSlideComplete: function(){
jQuery('.upsell-arrow.next').addClass('disabled');
},
onSlideChange: function(){
jQuery('.upsell-arrow.prev').removeClass('disabled');
jQuery('.upsell-arrow.next').removeClass('disabled');
}
});               
</script>           







<!-- /MODULE Block best sellers -->
