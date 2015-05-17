{if $categoryProducts}
<h5 class="related-product-h5">{$categoryProducts|@count} {l s="Other products in this category" mod='psmodproductscategory'}</h5>

<div class="box-related-wrapper">
    <div class="box-collateral box-related clearfix">
        <div class="slider">
               {foreach from=$categoryProducts item='categoryProduct' name=categoryProduct}

                <div  class="ajax_block_product  item slide"> 
                {if isset($categoryProduct.on_sale) && $categoryProduct.on_sale && isset($categoryProduct.show_price) && $categoryProduct.show_price && !$PS_CATALOG_MODE} <div class="saleproduct_label">{l s='Sale' mod='psmodproductscategory'}</div>{/if}
            {if isset($categoryProduct.new) && $categoryProduct.new == 1}<div class="newproduct_label">{l s='New' mod='psmodproductscategory'}</div>{/if}
           
            <div class="box-product-item">
                <div class="box-product-buttons">
                    <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                    <div class="buttons-compare link-compare"  id="comparator_item_{$categoryProduct.id_product}" ></div>
                    <div class="buttons-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$categoryProduct.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;"></div>    
                </div>
                <div class="box-line"></div>
                <div class="view-first">
                    <div class="view-content">
                        <div class="image">
                            <a href="{$categoryProduct.link}" title="{$categoryProduct.name|escape:html:'UTF-8'}" class="product_img_link">
                                <img src="{$link->getImageLink($categoryProduct.link_rewrite, $categoryProduct.id_image, 'home_default')}"  alt="{$categoryProduct.name|escape:html:'UTF-8'}" />
                            </a>
                        </div>
                        <div class="name">
                            <a href="{$categoryProduct.link}" title="{$categoryProduct.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$categoryProduct.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                        </div>
                        {if ($categoryProduct.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $categoryProduct.available_for_order AND !isset($restricted_country_mode) AND $categoryProduct.minimal_quantity == 1 AND $categoryProduct.customizable != 2 AND !$PS_CATALOG_MODE}
                            {if ($categoryProduct.quantity > 0 OR $categoryProduct.allow_oosp)}
                                
                                <a class="exclusive ajax_add_to_cart_button buttons-cart" rel="ajax_id_product_{$categoryProduct.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$categoryProduct.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='psmodproductscategory'}"></a> 
                            {else}
                               <div class="out_of_stock">{l s='Out Of Stock' mod='psmodproductscategory'}</div>
                            {/if}
                        {/if}


                        <div class="price">
                            <div class="price-box">
                                 {if $categoryProduct.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  <p class="special-price"> <span class="price-label">{l s='Regular Price:' mod='psmodproductscategory'}</span> <span class="price" id="product-price">{if !$priceDisplay}{convertPrice price=$categoryProduct.price}{else}{convertPrice price=$categoryProduct.price_tax_exc}{/if}</span></p>{else}<div style="height:21px;"></div>{/if}
                                     
            </div>
        </div>
    </div>
</div>
</div>
</div>
{/foreach}
</div>  
    </div>
    <div class="prev related-arrow"></div>
    <div class="next related-arrow"></div>

 {/if}              
<script type="text/javascript">
    jQuery('.related-arrow.prev').addClass('disabled');
    jQuery('.box-related').iosSlider({
        desktopClickDrag: true,
        snapToChildren: true,
        infiniteSlider: false,
        navNextSelector: '.related-arrow.next',
        navPrevSelector: '.related-arrow.prev',

        onFirstSlideComplete: function(){
        jQuery('.related-arrow.prev').addClass('disabled');
        },
        onLastSlideComplete: function(){
        jQuery('.related-arrow.next').addClass('disabled');
        },
        onSlideChange: function(){
        jQuery('.related-arrow.prev').removeClass('disabled');
        jQuery('.related-arrow.next').removeClass('disabled');
        }
    });               
</script>           
           
</div>


