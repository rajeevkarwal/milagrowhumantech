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
     <div class="block block-related">
         <div class="block-title ma-new-vertscroller-title"><strong><span class="word1">{l s='Top' mod='tdblockbestsellers'}</span> <span class="word2">{l s='Sellers' mod='tdblockbestsellers'}</span> </strong></div>

    <div class="block-content">
        
        {if $best_sellers|@count > 0}
        <ol id="block-related" class="mini-products-list">
                {foreach from=$best_sellers item=product name=myLoop}
            <li class="item odd">
                                                            
                    <div class="product">
                    <a class="product-image" title="{$product.legend|escape:'htmlall':'UTF-8'}" href="{$product.link}"><img width="75" height="75" alt="{$product.legend|escape:'htmlall':'UTF-8'}" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'medium_default')}"></a>
                    <div class="product-details">
                        <p class="product-name"><a href="{$product.link}">{$product.name|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}</a></p>
                        

                
    <div class="price-box">
                                                            <span id="product-price-3-related" class="regular-price">
                                            <span class="price">{$product.price}</span>                                    </span>
                        
        </div>

                    </div>
                </div>
            </li>
{/foreach}
                </ol>
       {else}
		<p>{l s='No best sellers at this time' mod='blockbestsellers'}</p>
	{/if}
    </div>
           
</div>
