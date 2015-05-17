{if $categoryProducts}
<div class="ma-upsellslider-container">
    <div class="ma-upsellslider-title">
        <h2>
            <span class="word1">{$categoryProducts|@count} {l s="Other products in this category" mod='tdproductscategory'}</span> 
        </h2>
    </div>
    <div class="flexslider carousel">

        <div class="flex-viewport">
            <ul class="slides">
                  {foreach from=$categoryProducts item='categoryProduct' name=categoryProduct}
                <li class="ajax_block_product newproductslider-item" >
                  <div class="item-inner">
                                                  {if isset($categoryProduct.new) && $categoryProduct.new == 1}<div class="label-pro-new">{l s='New' mod='tdproductscategory'}</div>{/if}
{if isset($categoryProduct.on_sale) && $categoryProduct.on_sale && isset($categoryProduct.show_price) && $categoryProduct.show_price && !$PS_CATALOG_MODE} <div class="label-pro-sale">{l s='Sale' mod='tdproductscategory'}</div>{/if}
                            <a class="product-image" href="{$categoryProduct.link}" title="{$categoryProduct.name|escape:html:'UTF-8'}" class="product_img_link">
                                <img src="{$link->getImageLink($categoryProduct.link_rewrite, $categoryProduct.id_image, 'home_default')}"  alt="{$categoryProduct.name|escape:html:'UTF-8'}" />
                            </a>

                            <h3 class="product-name"><a href="{$categoryProduct.link}" title="{$categoryProduct.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$categoryProduct.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}</a></h3>
                            <div class="price-box">
                                <span id="product-price-1-upsell" class="regular-price">
                                    <span class="price">
                        {if $categoryProduct.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}{convertPrice price=$categoryProduct.price}{else}{convertPrice price=$categoryProduct.price_tax_exc}{/if}{else}{/if}</span>   
                </span>                                   

            </div>

        </div>

                </li>
            {/foreach}  
            </ul>
        </div>
        <ul class="flex-direction-nav">
            <li>
                <a href="#" class="flex-prev">{l s='Previous' mod='tdproductscategory'}</a>
            </li>
            <li>
                <a href="#" class="flex-next">{l s='Next' mod='tdproductscategory'}</a>
            </li>
        </ul>
    </div>
</div>
            <script type="text/javascript">
        //&lt;![CDATA					
        $jq(document).ready(function() {
            $jq('.ma-upsellslider-container .flexslider').flexslider({
                                slideshow: false,
                                itemWidth: 200,
                itemMargin: 15,
                minItems: 1,
                maxItems: 3,
                slideshowSpeed: 3000,
                animationSpeed: 600,
                
                                controlNav: false,
                                                animation: "slide"
            });
        });
        //]]&gt;
    </script>
{/if}    