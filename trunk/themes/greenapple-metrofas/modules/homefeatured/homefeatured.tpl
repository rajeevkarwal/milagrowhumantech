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

<div id="compare_block">
    <div class="block_content" id="fc_comparison">
    </div>
</div>

<div class="ma-featured-products">
    <div class="ma-newproductslider-title"><h2><span class="word1">{l s='Best' mod='homefeatured'}</span> <span class="word2">{l s='Sellers' mod='homefeatured'}</span> </h2></div>
   {if isset($products) AND $products}
    <div class="category-products row-fluid">
                       {assign var='liHeight' value=250}
			{assign var='nbItemsPerLine' value=4}
			{assign var='nbLi' value=$products|@count}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
			  {$j=0}
                            {$i=1}
                        {foreach from=$products item=product name=homeFeaturedProducts}
				{math equation="(total%perLine)" total=$smarty.foreach.homeFeaturedProducts.total perLine=$nbItemsPerLine assign=totModulo}
				{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
                       
                     {if $themesdev.td_home_sidebar=="enable"}  
                               {if $j%3==0}
                                  <ul class="products-grid  first">
                                {/if} 
                     {else}
                         {if $j%4==0}
                                  <ul class="products-grid  first">
                                {/if}
                    {/if}
         
                <li  id="{$product.id_product}" class="ajax_block_product{if $smarty.foreach.homeFeaturedProducts.first}{elseif $smarty.foreach.homeFeaturedProducts.last}{else}{/if} {if $smarty.foreach.homeFeaturedProducts.iteration%$nbItemsPerLine == 0}{elseif $smarty.foreach.homeFeaturedProducts.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.homeFeaturedProducts.iteration > ($smarty.foreach.homeFeaturedProducts.total - $totModulo)}{/if} {if $themesdev.td_home_sidebar=="enable"}span4 {else}span3{/if} item  {if ($i%5)==0} margin-left {else} {/if}" >

                    <div class="item-inner">
                        {*<div class="video_{$product.id_product}" style="display: none"><a href="#"*}
                                                                                          {*class="iframe videoPopout"></a></div>*}
                        <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_img_link product-image">
                            {if isset($product.condition) && $product.condition eq 'refurbished'}
                            <div class="label-pro-refurbished">{l s='Refurbished'}</div>    
                           {elseif isset($product.condition) && $product.condition eq 'used'}
						   <div class="label-pro-refurbished">{l s='Used'}</div>
						   {elseif isset($product.condition) && $product.condition eq 'combo'}
						   <div class="label-pro-refurbished">{l s='Combo'}</div>
						   {elseif isset($product.new) && $product.new == 1}
						   <div class="label-pro-new">{l s='New' mod='homefeatured'}</div>
                            {/if}

                            {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE} <div class="label-pro-sale">{l s='Offer' mod='homefeatured'}</div>{/if}
                            <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
                        </a>
                        <div class="product-details">	
                            <h2 class="product-name"> <a href="{$product.link}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}</a></h2>
                            <div class="product-highlight-feature">
                                <h6 id="product_highlight_feature_fp_{$product.id_product}">&nbsp;</h6>
                            </div>
                            <!-- rating block-->
                            <div class="product-rating">
                                <div id="rating_block_{$product.id_product}" style="display: inline-block"></div>
                                <span class="video_{$product.id_product}" style="display: none"><a href="#"
                                                                                                  class="iframe videoPopout"></a></span>
                            </div>

                            <!-- end rating block-->
                            <div class="price-box">


                                {if ((isset($product.on_sale) && $product.on_sale) || (isset($product.reduction) && $product.reduction)) && $product.price_without_reduction > $product.price && $product.show_price AND !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
                                    <p class="old-price">
                                        <span class='price'>
                                            {convertPrice price=$product.price_without_reduction}
                                        </span>
                                    </p>{else}     
                                {/if}
                                <p class="special-price"> 
                    {if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}<span class="price">{convertPrice price=$product.price}</span>{else}<span class="price">{convertPrice price=$product.price_tax_exc}</span>{/if}{else}<div style="height:21px;"></div>{/if}
                </p>



            </div>
            <div class="actions">
                              <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product-image product_img_link hidden"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" /></a>
                                                                                    
                                              {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                                        {if ($product.quantity > 0 OR $product.allow_oosp)}

                                                         <button type="button" rel="ajax_id_product_{$product.id_product}" class="button btn-cart add-to-cart exclusive ajax_add_to_cart_button" onclick="setPLocation('{$link->getPageLink('cart')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add')" title="{l s='Add to cart' mod='homefeatured'}"><span>{l s='Add to cart' mod='homefeatured'}</span></button>
							{else}
                                                            <button type="button" class="button btn-cart" title="{l s='Out Of Stock' mod='homefeatured'}"><span>{l s='Out Of Stock' mod='homefeatured'}</span></button>
							{/if}
						{else}
	                                                   <span style="height: 31px;"></span>
						{/if}
                
                

         
                
                
                <ul class="add-to-links">
                    <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                    <li style="display: none" class="cod_{$product.id_product}"><a rel="tooltip"
                                                                                   title="{l s='COD Available'}"
                                                                                   class="link-cod"></a></li>
                    <li style="display: none" class="emi_{$product.id_product}"><a rel="tooltip"
                                                                                   title="{l s='EMI Available'}"
                                                                                   class="link-emi"></a></li>

                    <li><a rel="tooltip"  onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;" title="{l s='Add to Wishlist' mod='homefeatured'}" class="link-wishlist">{l s='Add to Wishlist' mod='homefeatured'}</a></li>
                    <li><span class="separator">|</span>
                        <a id="comparator_item_{$product.id_product}" rel="tooltip"  title="{l s='Add to Compare' mod='homefeatured'}"  class="link-compare link-compare">{l s='Add to Compare' mod='homefeatured'}</a>
                    </li>


                </ul>
            </div>
        </div>          

</div>


</li>
{if $themesdev.td_home_sidebar=="enable"}  
		     {if $i%3==0} </ul> {/if}
              {else}
                    {if $i%4==0} </ul> {/if}
      {/if}                
                                      {$j=$j+1}
            {$i=$i+1}
                        {/foreach}


</div>	
                        {else}
    <p>{l s='No featured products' mod='homefeatured'}</p>
{/if}
<!-- end exist product -->
</div> <!-- end products list -->



<!--<div class="content-sample-block">
    <div class="row-fluid">
          {$themesdev.td_hcustomb_content|html_entity_decode}
    </div>
</div>-->

<div class="ma-newproductslider-container">
<div class="ma-newproductslider-title"><h2><span class="word1">{l s='Latest' mod='tdnewproducts'}</span> <span class="word2">{l s='Products' mod='tdnewproducts'}</span> </h2></div>
<div class="flexslider carousel">
{if $new_products !== false}
        <ul class="slides">
        {foreach from=$new_products item=newproduct name=myLoop} 
            <li class="newproductslider-item {$newproduct.condition|escape:html:'UTF-8'}" id="{$newproduct.id_product}" style="width: 280px !important;margin-bottom: 21px;margin-right: 4px;">
                 <div class="item-inner">
                    
                    <a href="{$newproduct.link}" title="{$newproduct.name|escape:html:'UTF-8'}" class="product_img_link product-image">
                        {if isset($newproduct.condition) && $newproduct.condition eq 'refurbished'}
                        <div class="label-pro-refurbished">{l s='Refurbished'}</div>
						{elseif isset($newproduct.condition) && $newproduct.condition eq 'used'}
                        <div class="label-pro-refurbished">{l s='Used'}</div>
						{elseif isset($newproduct.condition) && $newproduct.condition eq 'combo'}
                        <div class="label-pro-refurbished">{l s='Combo'}</div>
                        {elseif isset($newproduct.new) && $newproduct.new == 1}
						<div class="label-pro-new">{l s='New' mod='tdnewproducts'}</div>{/if}

                       {if isset($newproduct.on_sale) && $newproduct.on_sale && isset($newproduct.show_price) && $newproduct.show_price && !$PS_CATALOG_MODE} <div class="label-pro-sale">{l s='Offer' mod='tdnewproducts'}</div>{/if}
                        <img src="{$link->getImageLink($newproduct.link_rewrite, $newproduct.id_image, 'home_default')}"  alt="{$newproduct.name|escape:html:'UTF-8'}" />
                    </a>
                    <h2 class="product-name"> <a href="{$newproduct.link}" title="{$newproduct.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$newproduct.name|truncate:20:'...'|escape:'htmlall':'UTF-8'}</a></h2>
                     <div class="product-highlight-feature">
                         <h6 id="product_highlight_feature_{$newproduct.id_product}">&nbsp;</h6>
                     </div>
                     <!-- rating block-->
                     <div class="product-rating">
                         <div id="rating_block_new_{$newproduct.id_product}" style="display: inline-block"></div>
                                <span id="video_new_{$newproduct.id_product}" style="display: none"><a href="#"
                                                                                                   class="iframe_new videoPopout"></a></span>
                     </div>


                     <!-- end rating block-->

                     <div class="price-box">


                        {if ((isset($newproduct.on_sale) && $newproduct.on_sale) || (isset($newproduct.reduction) && $newproduct.reduction)) && $newproduct.price_without_reduction > $newproduct.price && $newproduct.show_price AND !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
                            <p class="old-price">
                                <span class='price'>
                                    {convertPrice price=$newproduct.price_without_reduction}
                                </span>
                            </p>{else}     
                        {/if}
                        <p class="special-price"> 
            {if $newproduct.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}<span class="price">{convertPrice price=$newproduct.price}</span>{else}<span class="price">{convertPrice price=$newproduct.price_tax_exc}</span>{/if}{else}<div style="height:21px;"></div>{/if}
        </p>



    </div>
    <div class="actions">

        {if ($newproduct.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $newproduct.available_for_order AND !isset($restricted_country_mode) AND $newproduct.minimal_quantity == 1 AND $newproduct.customizable != 2 AND !$PS_CATALOG_MODE}
            {if ($newproduct.quantity > 0 OR $newproduct.allow_oosp)}
                 <button type="button" rel="ajax_id_product_{$newproduct.id_product}"  class="button btn-cart add-to-cart exclusive ajax_add_to_cart_button" onclick="setPLocation('{$link->getPageLink('cart')}?qty=1&amp;id_product={$newproduct.id_product}&amp;token={$static_token}&amp;add')" title="{l s='Add to cart' mod='tdnewproducts'}"><span>{l s='Add to cart' mod='tdnewproducts'}</span></button>
							{else}
                                                            <button type="button" class="button btn-cart" title="{l s='Out Of Stock' mod='tdnewproducts'}"><span>{l s='Out Of Stock' mod='tdnewproducts'}</span></button>
                                                            

        {/if}{/if}
        <ul class="add-to-links">
            <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
            <li style="display: none" id="cod_new_{$newproduct.id_product}"><a rel="tooltip"
                                                                           title="{l s='COD Available'}"
                                                                           class="link-cod"></a></li>
            <li style="display: none" id="emi_new_{$newproduct.id_product}"><a rel="tooltip"
                                                                           title="{l s='EMI Available'}"
                                                                           class="link-emi"></a></li>
            <li><a rel="tooltip"  onclick="WishlistCart('wishlist_block_list', 'add', '{$newproduct.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;" title="{l s='Add to Wishlist' mod='tdnewproducts'}" class="link-wishlist">{l s='Add to Wishlist' mod='tdnewproducts'}</a></li>
            <li><span class="separator">|</span>
                <a id="comparator_item_{$newproduct.id_product}" rel="tooltip"  title="{l s='Add to Compare' mod='tdnewproducts'}"  class="link-compare link-compare">{l s='Add to Compare' mod='tdnewproducts'}</a>
            </li>


        </ul>
    </div>

</div>
                
                
                
            </li>  
        {/foreach}
        </ul>
{else}
    <p>{l s='No new products at this time' mod='tdnewproducts'}</p>
{/if}

    <script type="text/javascript">
$jq('.ma-newproductslider-container .flexslider').flexslider({
slideshow: false,
itemWidth: 280,
itemMargin: 5,
minItems: 1,
maxItems: 12,
slideshowSpeed: 3000,
animationSpeed: 600,
controlNav: false,
animation: "slide"
});
    </script>
</div>	
</div>


</div>
</div>
{if $themesdev.td_home_sidebar=="enable"} 
</div>
{/if}
