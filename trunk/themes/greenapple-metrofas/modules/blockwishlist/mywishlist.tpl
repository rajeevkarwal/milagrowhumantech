{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{capture name=path}<a href="{$link->getPageLink('my-account', true)}">{l s='My account' mod='blockwishlist'}</a><span
        class="navigation-pipe">{$navigationPipe}</span>{l s='My wishlists' mod='blockwishlist'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<style>
    a.nextButton, a.prevButton {
        overflow: visible;
        width: auto;
        border: 0;
        padding: 0;
        margin: 0;
        background: transparent;
        cursor: pointer;
        background: #ffa930;
        color: white;
        padding: 7px;
    }

    a.nextButton:hover, a.prevButton:hover {
        color: white !important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {

        var ids = $(".ajax_block_product").map(function () {
            return this.id;
        });
        //array of ids
        var idsArray = ids.toArray();
        if (idsArray.length > 0) {
            $.ajax({
                type: 'POST',
                url: baseDir + 'index.php?fc=module&module=featurecategories&controller=compare',
                async: true,
                cache: false,
                data: 'action=productWiseIcons&productIds=' + idsArray,
                success: function (jsonData, textStatus, jqXHR) {
                    var obj = jQuery.parseJSON(jsonData);
                    $.each(obj, function (key, value) {
                        $.each(value, function (key1, value1) {

                            if (value1.status) {
                                key1 = key1.toLowerCase();
                                if (key1 == 'video') {
                                    var videoId = value1.description;
                                    if (videoId) {
                                        $('.' + key1 + '_' + key).find('a').attr('href', 'http://www.youtube.com/embed/' + videoId);
                                        $('.' + key1 + '_' + key).show();
                                    }

                                }
                                else if (key1 == 'producthighlightfeatures') {
                                    if (value1.description) {
                                        $('#product_highlight_feature_' + key).html(value1.description);
                                    }

                                }
                                else {
                                    $('.' + key1 + '_' + key).show();
                                }

                            }
                        });
                    });
                }
            });
        }
        var fancyBoxObj = new Object();
        fancyBoxObj.showNavArrows = false;
        $('a.iframe').fancybox(fancyBoxObj);
    });
</script>
<div class="container">
    <div class="contain-size">
        <div class="main">
            <div class="main-inner">
                <div class="row-fluid show-grid">
                    <div class="offset2" id="compare_block">
                        <div class="block_content" id="fc_comparison">
                        </div>
                    </div>
                </div>
                <div class="std">
                    <div class="page-title">
                        <h1>{l s='My wishlist' mod='blockwishlist'}</h1>

                        {*<p class="wishlisturl pull-right">Permalink : <input type="text"*}
                                                                             {*value="{$base_dir_ssl}modules/blockwishlist/view.php?token={$token|escape:'htmlall':'UTF-8'}"*}
                                                                             {*readonly="readonly"/></p>*}
                    </div>
                    <div class="list-wishlist products-list">
                        <p class="cms-banner-img"><img src="/img/cms/cms-banners/wishlist.png" alt="milagrow-wishlist-banner"></p>
                        {include file="$tpl_dir./errors.tpl"}

                        {foreach $products as $product}
                            <li class="ajax_block_product {if $smarty.foreach.products.first}first{elseif $smarty.foreach.products.last}last{else}{/if} {if $smarty.foreach.products.iteration%$nbItemsPerLine == 0}{elseif $smarty.foreach.products.iteration%$nbItemsPerLine == 1} {/if} {if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModulo)}{/if} item odd "
                                id="{$product.id_product}">

                                <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}"
                                   class="product_img_link product-image ">
                                    {if isset($product.condition) && $product.condition eq 'refurbished'}
                                        <div class="label-pro-refurbished-list">{l s='Refurbished'}</div>
                                    {elseif isset($product.new) && $product.new == 1}
                                        <div class="label-pro-new">{l s='New'}</div>{/if}
                                    {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
                                        <div class="label-pro-sale">{l s='Sale' }</div>{/if}

                                    <img class="fade-image"
                                         src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"
                                         alt="{$product.name|escape:html:'UTF-8'}"/>
                                </a>

                                <div class="product-shop">
                                    <div class="f-fix">
                                        <h2 class="product-name"><a href="{$product.link}"
                                                                    title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a>
                                        </h2>

                                        <!-- rating block-->
                                        <div class="product-rating">
                                            <div class="mg-stars-small" title="{$product.rating|round:2} stars">
                                                <div class="product_rating"
                                                     style="width:{($product.rating/5)*100}%;">
                                                </div>
                                            </div>
                                            <span>({$product.reviews} ratings)  <span
                                                        class="video_{$product.id_product}" style="display: none"><a
                                                            rel="tooltip"
                                                            title="{l s='Watch Video'}" href="#"
                                                            class="iframe videoPopout-list"></a>
                                            </span></span>

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
                                                {if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}  {if !$priceDisplay}
                                                    <span class="price">{convertPrice price=$product.price}</span>{else}
                                                    <span
                                                            class="price">{convertPrice price=$product.price_tax_exc}</span>{/if}{else}

                                            <div style="height:21px;"></div>{/if}
                                            </p>


                                        </div>


                                        <div class="desc std">
                                            {$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
                                            <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}"
                                               class="link-learn">{l s='Learn'} More</a>
                                        </div>
                                        <p class="product-list-button">
                                            <a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}"
                                               class="product_image hidden"><img
                                                        src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"
                                                        alt="{$product.name|escape:html:'UTF-8'}"/></a>
                                            {*{if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}*}
                                            {if ($product.quantity > 0 OR $product.allow_oosp)}
                                                <button class="exclusive ajax_add_to_cart_button info button btn-cart"
                                                        rel="ajax_id_product_{$product.id_product}"
                                                        onclik="{$link->getPageLink('cart',false, NULL, "add&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)}"
                                                        title="{l s='Add to cart'}">
                                                    <span><span>{l s='Add to cart'}</span></span>
                                                </button>
                                            {else}
                                                <button type="button" title="{l s='Out of Stock' }"
                                                        class="button btn-cart">
                                                    <span><span>{l s='Out of Stock' }</span></span></button>
                                            {/if}

                                            {*{/if}*}
                                        </p>
                                        <ul class="add-to-links">
                                            <input type="hidden" name="qty" id="quantity_wanted" class="text"
                                                   value="1" size="2"
                                                   maxlength="3"/>
                                            <li><a rel="tooltip"
                                                   onclick="WishlistProductManageDeletion('wishlist_block_list', 'delete', {$id_wishlist},'{$product.id_product|intval}', 0,1,''); return false;"
                                                   title="{l s='Remove Product From WishList'}"
                                                   class="link-wishlist"><span></span>{l s='Remove From WishList'}
                                                </a></li>
                                            <li><span class="separator">|</span>
                                                <a rel="tooltip" id="comparator_item_{$product.id_product}"
                                                   class="link-compare link-compare"
                                                   title="{l s='Add to Compare'}"><span></span>{l s='Add to Compare' }
                                                </a>
                                            </li>
                                            <li style="display: none" class="cod_{$product.id_product}"><a
                                                        rel="tooltip"
                                                        title="{l s='COD Available'}"
                                                        class="link-cod-list"><span></span>{l s='COD Available' }
                                                </a></li>
                                            <li style="display: none" class="emi_{$product.id_product}"><a
                                                        rel="tooltip"
                                                        title="{l s='EMI Available'}"
                                                        class="link-emi-list"><span></span>{l s='EMI Available' }
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>

                            </li>
                        {/foreach}

                        <div class="page" style="margin-bottom: 20px" align="center">
                            {if $previous>0}
                                <a class="prevButton" id="previous-btn" href="?page={$previous}">Prev</a>
                            {/if}
                            {if $next>0}
                                <a class="nextButton" id="next-btn" href="?page={$next}">Next</a>
                            {/if}
                        </div>

                        <ul class="footer_links">
                            <li><a href="{$link->getPageLink('my-account', true)}"><img
                                            src="{$img_dir}icon/my-account.gif" alt="" class="icon"/></a><a
                                        href="{$link->getPageLink('my-account', true)}">{l s='Back to Your Account' mod='blockwishlist'}</a>
                            </li>
                            <li class="right"><a href="{$base_dir}"><img src="{$img_dir}icon/home.gif" class="icon"
                                                                         alt=""/></a><a
                                        href="{$base_dir}">{l s='Home' mod='blockwishlist'}</a></li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>