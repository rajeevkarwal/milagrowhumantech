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

{if isset($products)}
    <!-- Products list -->
    <div id="products_wrapper">
        <ul class="products-grid columns4" id="grid_view_product">
            {$i=1}
            {foreach from=$products item=product name=products}
                <li  class="ajax_block_product {if $smarty.foreach.products.first}first{elseif $smarty.foreach.products.last}last{/if} {if $smarty.foreach.products.index % 2} {else}{/if} {if ($i%4)==0} margin-right {else} {/if}item">
                {if isset($product.new) && $product.new == 1}<div class="newproduct_grid">{l s='New'}</div>{/if}
            {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE} <div class="saleproduct">{l s='Sale'}</div>{/if}

            <!-- product -->
            <div class="box-product-item">
                <div class="view-first">
                    <div class="view-content">
                        <div class="image">
                            <a id="productimgover1" href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_img_link" id="productimgover22">
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
                            </a>
                        </div>
                        <div class="bottom-block">
                            <div class="name">
                                <a id="productname1" href="{$product.link}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>

                            </div>

                            {if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
                                {if ($product.quantity > 0 OR $product.allow_oosp)}

                                    <a class="ajax_add_to_cart_button link-cart" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homefeatured'}">{l s='Add to cart' }</a>
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
        <div class="image-rating"></div> 
        <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
        <div class="btn-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;">{l s='Add to Wish List'}</div>  
        <div class="btn-compare link-compare"  id="comparator_item_{$product.id_product}" >{l s='Add to Compare'}</div>
    </div>
</div>
</div>
<!-- / product -->
</li>  
{$i=$i+1}
{/foreach}           
</ul>


<ol id="products-list" class="products-list">
    {foreach from=$products item=product name=products}
        <li  class="ajax_block_product {if $smarty.foreach.products.first}first{elseif $smarty.foreach.products.last}last{/if} {if $smarty.foreach.products.index % 2} {else}{/if} item">
        {if isset($product.new) && $product.new == 1}<div class="newproduct_grid">{l s='New'}</div>{/if}
    {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE} <div class="saleproduct">{l s='Sale'}</div>{/if}


    <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_img_link product-image " id="productimgover22">
        <img  class="fade-image" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
    </a>
    <div class="product-shop">
        <div class="f-fix">
            <h2 class="product-name">
                <a href="{$product.link}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
            </h2>
            <div id="productimgover1" style="display: none;">
                <img   src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
            </div>
            <div id='productname1' style='display:none'>{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}</div>
            <div class="desc std">
                {*{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'} *}
                {$product.description_short|truncate:300:'...'}
                <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="link-learn">{l s='Learn'}More</a>
                <div class="btn-product clearfix">
                    <input type="hidden" name="qty" id="quantity_wanted" class="text"  value="1" size="2" maxlength="3" />
                    <div class="btn-wish" onclick="WishlistCart('wishlist_block_list', 'add', '{$product.id_product|intval}', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;">{l s='Add to Wish List'}</div>  
                    <div class="btn-compare link-compare"  id="comparator_item_{$product.id_product}" >{l s='Add to Compare'}</div>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="addtocont">
        <div class="price-box">


            <p class="old-price">
                {if ((isset($product.on_sale) && $product.on_sale) || (isset($product.reduction) && $product.reduction)) && $product.price_without_reduction > $product.price && $product.show_price AND !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
                    <span class="price">
                        {convertPrice price=$product.price_without_reduction}
                    </span>
                {else}     
                {/if}
            </p>

            <p class="special-price">
{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}   <span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>{else}<div style="height:21px;"></div>{/if}


</p>

</div>

<a href="{$product.link|escape:'htmlall':'UTF-8'}" style="display:none;"  title="{$product.name|escape:'htmlall':'UTF-8'}" class="product-image product_img_link">
    <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" width="135" alt="{$product.name|escape:'htmlall':'UTF-8'}" />
</a>

{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
    {if ($product.allow_oosp || $product.quantity > 0)}
        {if isset($static_token)}
            <button rel="ajax_id_product_{$product.id_product|intval}" title="{l s='Add to cart'}" class="ajax_add_to_cart_button button btn-cart" onclik="{$link->getPageLink('cart',false, NULL, "add&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)}"><span><span>{l s='Add to cart'}</span></span></button>					
        {else}
            <button rel="ajax_id_product_{$product.id_product|intval}" title="{l s='Add to cart'}" class="ajax_add_to_cart_button button btn-cart" onclik="{$link->getPageLink('cart',false, NULL, "add&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)}"><span><span>{l s='Add to cart'}</span></span></button>
        {/if}						
    {else}
        <button title="{l s='Out of stock'}" class="ajax_add_to_cart_button button btn-cart" ><span><span>{l s='Out of Stock'}</span></span></button>
    {/if}
{/if} 
</div>
</li>
{/foreach}
</ol>        

</div>
<!-- /Products list -->
{/if}
