
<h1 class="products-block-header">{l s='NEW PRODUCTS' mod="psmodnewproducts"}</h1>
<p class="products-block-subheader">{l s="Best products for you" mod="psmodnewproducts"}</p>
<div class="clear">&nbsp;</div>
<p>    
<div class="saleproducts">
    <div class="carousel">
        {if $new_products !== false}
            {assign var='liHeight' value=250}
            {assign var='nbItemsPerLine' value=4}
            {assign var='nbLi' value=$new_products|@count}
            {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
            {math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
            <div class="slider">
                {foreach from=$new_products item=newproduct name=myLoop} 
                    {math equation="(total%perLine)" total=$smarty.foreach.myLoop.total perLine=$nbItemsPerLine assign=totModulo}
                {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
                <div  class="ajax_block_product {if $smarty.foreach.myLoop.first}{elseif $smarty.foreach.myLoop.last}{else}{/if} {if $smarty.foreach.myLoop.iteration%$nbItemsPerLine == 0}{elseif $smarty.foreach.myLoop.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.myLoop.iteration > ($smarty.foreach.myLoop.total - $totModulo)}{/if} slide"> 

                {if isset($newproduct.on_sale) && $newproduct.on_sale && isset($newproduct.show_price) && $newproduct.show_price && !$PS_CATALOG_MODE} <div class="saleproduct_label">{l s='Sale' mod='psmodnewproducts'}</div>{/if}
            {if isset($newproduct.new) && $newproduct.new == 1}<div class="newproduct_label">{l s='New' mod='psmodnewproducts'}</div>{/if}

            <div class="box-product-item">
                <div class="box-product-buttons">
                    <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                    <div class="buttons-compare link-compare"  id="comparator_item_{$newproduct.id_product}" ></div>
                    <div class="buttons-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$newproduct.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"></div>  
                </div>
                <div class="box-line"></div>
                <div class="view-first">
                    <div class="view-content">
                        <div class="image">
                            <a href="{$newproduct.link}" title="{$newproduct.name|escape:html:'UTF-8'}" class="product-image product_img_link">
                                <img src="{$link->getImageLink($newproduct.link_rewrite, $newproduct.id_image, 'home_default')}"  alt="{$newproduct.name|escape:html:'UTF-8'}" /> 
                            </a>
                        </div>
                        <div class="name">
                            <a href="{$newproduct.link}" title="{$newproduct.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}">{$newproduct.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                        </div>
                        {if ($newproduct.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $newproduct.available_for_order AND !isset($restricted_country_mode) AND $newproduct.minimal_quantity == 1 AND $newproduct.customizable != 2 AND !$PS_CATALOG_MODE}
                            {if ($newproduct.quantity > 0 OR $newproduct.allow_oosp)}
                                <a class="exclusive ajax_add_to_cart_button buttons-cart" rel="ajax_id_product_{$newproduct.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$newproduct.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='psmodnewproducts'}"></a> 
                            {else}
                                  <div class="out_of_stock">{l s='Out Of Stock' mod='psmodnewproducts'}</div>
                            {/if}
                        {/if}
                     <div class="price">
                            <div class="price-box">
                                 {if $newproduct.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  <p class="special-price"> <span class="price-label">{l s='Regular Price:' mod='psmodnewproducts'}</span> <span class="price" id="product-price">{if !$priceDisplay}{convertPrice price=$newproduct.price}{else}{convertPrice price=$newproduct.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
                                     
            </div>
        </div>

    </div>


</div>
</div>

</div>
{/foreach}
</div>    

{else}
    <p>{l s='No new products at this time' mod='psmodnewproducts'}</p>
{/if}
</div>
<div class="prev sale-arrow"></div>
<div class="next sale-arrow"></div>  
</div>     
<div class="clear"></div>
<style type="text/css">
    .sale-arrow {
        display:block;
    }
    .saleproducts .carousel {
        height:344px;
    }
    .saleproducts .slide {
        margin-bottom:0px;
    }
</style>
<script type="text/javascript">
    jQuery('.sale-arrow.prev').addClass('disabled');
    jQuery('.saleproducts .carousel').iosSlider({
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