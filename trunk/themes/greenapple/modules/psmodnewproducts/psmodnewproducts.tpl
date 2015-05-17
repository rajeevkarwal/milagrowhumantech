

<h1 class="products-block-header">{l s='New products' mod='psmodnewproducts'}</h1>
<div class="clear">&nbsp;</div>
<p>  
<div class="saleproducts">
  {if $new_products !== false}
        {assign var='liHeight' value=250}
        {assign var='nbItemsPerLine' value=4}
        {assign var='nbLi' value=$new_products|@count}
        {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
        {math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight} 
        <div class="carousel">
            <div class="slider">
                {foreach from=$new_products item=newproduct name=psmodnewproducts}
                    {math equation="(total%perLine)" total=$smarty.foreach.psmodnewproducts.total perLine=$nbItemsPerLine assign=totModulo}
                {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
           <div class="ajax_block_product {if $smarty.foreach.psmodnewproducts.first}first{elseif $smarty.foreach.psmodnewproducts.last}last{else}{/if} {if $smarty.foreach.psmodnewproducts.iteration%$nbItemsPerLine == 0}{elseif $smarty.foreach.psmodnewproducts.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.psmodnewproducts.iteration > ($smarty.foreach.psmodnewproducts.total - $totModulo)}{/if} slide"> 
                {if isset($newproduct.new) && $newproduct.new == 1}<div class="newproduct_grid">{l s='New' mod='psmodnewproducts'}</div>{/if}
            {if isset($newproduct.on_sale) && $newproduct.on_sale && isset($newproduct.show_price) && $newproduct.show_price && !$PS_CATALOG_MODE} <div class="saleproduct">{l s='Sale' mod='psmodnewproducts'}</div>{/if}
            <!-- product -->
            <div class="box-product-item">
                <div class="view-first">
                    <div class="view-content">
                        <div class="image">
                            <a href="{$newproduct.link}" title="{$newproduct.name|escape:html:'UTF-8'}" class="product_img_link">
                                <img src="{$link->getImageLink($newproduct.link_rewrite, $newproduct.id_image, 'home_default')}"  alt="{$newproduct.name|escape:html:'UTF-8'}" />
                            </a>
                        </div>
                        <div class="bottom-block">
                            <div class="name">
                                <a href="{$newproduct.link}" title="{$newproduct.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$newproduct.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                            </div>

                            {if ($newproduct.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $newproduct.available_for_order AND !isset($restricted_country_mode) AND $newproduct.minimal_quantity == 1 AND $newproduct.customizable != 2 AND !$PS_CATALOG_MODE}
                                {if ($newproduct.quantity > 0 OR $newproduct.allow_oosp)}

                                    <a class="ajax_add_to_cart_button link-cart" rel="ajax_id_product_{$newproduct.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$newproduct.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='psmodnewproducts'}">{l s='Add to cart' mod='psmodnewproducts'}</a>
                                {else}
                                    <div class="link-cart" >{l s='Out Of Stock' mod='psmodnewproducts'}</div>
                                {/if}
                            {/if}

                            <div class="price"> 
                {if $newproduct.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}{convertPrice price=$newproduct.price}{else}{convertPrice price=$newproduct.price_tax_exc}{/if}{else}{/if}
            </div>
        </div>
    </div>
    <div class="slide-block">
        <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
           <div class="image-rating"></div>
        <div class="btn-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$newproduct.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;">{l s='Add to Wish List' mod='psmodnewproducts'}</div>  
        <div class="btn-compare link-compare"  id="comparator_item_{$newproduct.id_product}" >{l s='Add to Compare' mod='psmodnewproducts'}</div>
    </div>
</div>
</div>
<!-- / product -->

</div>

{/foreach} 
</div>             
</div>
<div class="prev sale-arrow">&nbsp;</div>
<div class="next sale-arrow">&nbsp;</div>  
{else}
    <p>{l s='No new products at this time' mod='psmodnewproducts'}</p>
{/if}   

</div>     
<div class="clear"></div>
<script type="text/javascript">
    jQuery('.sale-arrow.prev').addClass('disabled');
    jQuery('.carousel').iosSlider({
    desktopClickDrag: true,
    snapToChildren: true,
    infiniteSlider: false,
    navNextSelector: '.sale-arrow.next',
    navPrevSelector: '.sale-arrow.prev',
    lastSlideOffset: 3,
    onFirstSlideComplete: function(){
    jQuery('.sale-arrow.prev').addClass('disabled');
},
onLastSlideComplete: function(){
jQuery('.sale-arrow.next').addClass('disabled');
},
onSlideChange: function(){
jQuery('.sale-arrow.prev').removeClass('disabled');
jQuery('.sale-arrow.next').removeClass('disabled');
}
});               
</script>    
</p>














<!-- /MODULE Block new products -->