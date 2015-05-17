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
<div class="ma-bestseller-vertscroller-wrap block"> 
    <div class="block-title ma-bestseller-vertscroller-title"><strong><span>{l s='Best Seller' mod='blockbestsellers'}</span></strong></div>
    <div class="block-content ma-bestseller-vertscoller-content">			
        {if $best_sellers|@count > 0}
            <ul id ="ma-bestseller-vertscroller-right" class="jcarousel jcarousel-skin-tango bestseller-vertscroller">
                {foreach from=$best_sellers item=product name=myLoop}
                    <li class="item">
                        <a href="{$product.link}" title="{$product.legend|escape:'htmlall':'UTF-8'}" class="product-image">
                            <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small_default')}" height="75" width="75" alt="{$product.legend|escape:'htmlall':'UTF-8'}" />
                        </a>
                        <div class="bestseller-detail">
                            <h2 class="product-name"><a href="{$product.link}" title="{$product.legend|escape:'htmlall':'UTF-8'}">{$product.name|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}</a></h2>

                            <div class="price-box">



                                <p class="old-price">
                                    <span class='price'>

                                    </span>
                                </p>    

                                <p class="special-price"> 
                                    <span class="price">{$product.price}</span>
                                </p>



                            </div>

                            <div class="mt-actions">
                            </div>
                        </div>     

                    </li>
                {/foreach}
            </ul>
        {else}
            <p>{l s='No best sellers at this time' mod='blockbestsellers'}</p>
        {/if}
        <script type="text/javascript">
            //<![CDATA[
            $jq(document).ready(function() {
            $jq('#ma-bestseller-vertscroller-right').jcarousel({
            vertical: true,
            wrap: 'circular',
            auto: 1,
            animation: 1000,
            scroll: 1						});
        $jq(".ma-bestseller-vertscroller-wrap .jcarousel-container-vertical, .ma-bestseller-vertscroller-wrap .jcarousel-clip-vertical")
        .css("width","172px")
        .css("height","330px");							
    });
    //]]>
        </script>
    </div>		
</div>        


<!-- /MODULE Block best sellers -->
