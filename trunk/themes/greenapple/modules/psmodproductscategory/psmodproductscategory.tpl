<div class="clear"></div>
{if $categoryProducts}
    
 <h1 class="products-block-header">{$categoryProducts|@count} {l s="Other products in this category" mod='psmodproductscategory'}</h1>
<div class="clear">&nbsp;</div>
<p>  
<div class="newproducts">
        <div class="carousel">
           
            <div class="slider">
                  {foreach from=$categoryProducts item='categoryProduct' name=categoryProduct}
              <div class="ajax_block_product  item slide"> 
            {if isset($categoryProduct.new) && $categoryProduct.new == 1}<div class="newproduct_grid">{l s='New' mod='homefeatured'}</div>{/if}
            {if isset($categoryProduct.on_sale) && $categoryProduct.on_sale && isset($categoryProduct.show_price) && $categoryProduct.show_price && !$PS_CATALOG_MODE} <div class="saleproduct">{l s='Sale' mod='homefeatured'}</div>{/if}
            <!-- product -->
            <div class="box-product-item">
                <div class="view-first">
                    <div class="view-content">
                        <div class="image">
                            <a href="{$categoryProduct.link}" title="{$categoryProduct.name|escape:html:'UTF-8'}" class="product_img_link">
                                <img src="{$link->getImageLink($categoryProduct.link_rewrite, $categoryProduct.id_image, 'home_default')}"  alt="{$categoryProduct.name|escape:html:'UTF-8'}" />
                            </a>
                        </div>
                        <div class="bottom-block">
                            <div class="name">
                                <a href="{$categoryProduct.link}" title="{$categoryProduct.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$categoryProduct.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                            </div>

                            {if ($categoryProduct.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $categoryProduct.available_for_order AND !isset($restricted_country_mode) AND $categoryProduct.minimal_quantity == 1 AND $categoryProduct.customizable != 2 AND !$PS_CATALOG_MODE}
                                {if ($categoryProduct.quantity > 0 OR $categoryProduct.allow_oosp)}

                                <a class="ajax_add_to_cart_button link-cart" rel="ajax_id_product_{$categoryProduct.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$categoryProduct.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homefeatured'}">{l s='Add to cart' mod='homefeatured'}</a>
                                {else}
                                    <div class="link-cart" >{l s='Out Of Stock' mod='homefeatured'}</div>
                                {/if}
                            {/if}

               <div class="price"> 
                {if $categoryProduct.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}{convertPrice price=$categoryProduct.price}{else}{convertPrice price=$categoryProduct.price_tax_exc}{/if}{else}{/if}
            </div>
        </div>
    </div>
    <div class="slide-block">
     
        <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
         <div class="image-rating"></div>
        <div class="btn-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$categoryProduct.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;">{l s='Add to Wish List' mod='homefeatured'}</div>  
        <div class="btn-compare link-compare"  id="comparator_item_{$categoryProduct.id_product}" >{l s='Add to Compare' mod='homefeatured'}</div>
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

 {/if}      
