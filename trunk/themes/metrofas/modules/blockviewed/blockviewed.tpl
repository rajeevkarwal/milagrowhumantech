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

<!-- Block Viewed products -->



<div class="ma-new-vertscroller-wrap block"> 
    <div class="block-title ma-new-vertscroller-title"><strong><span>    {l s='Viewed Products' mod='blockviewed'}</span></strong></div>
    <div class="block-content ma-new-vertscoller-content">			
        <ul id ="ma-new-vertscroller-left" class="jcarousel jcarousel-skin-tango new-vertscroller">
                 {foreach from=$productsViewedObj item=viewedProduct name=myLoop}
            <li class="item  first">	
                 <a  href="{$viewedProduct->product_link}" title="{l s='About' mod='blockviewed'} {$viewedProduct->name|escape:html:'UTF-8'}" class="product-image">
                        <img  width="75" height="75" src="{if isset($viewedProduct->id_image) && $viewedProduct->id_image}{$link->getImageLink($viewedProduct->link_rewrite, $viewedProduct->cover, 'medium_default')}{else}{$img_prod_dir}{$lang_iso}-default-medium_default.jpg{/if}" alt="{$viewedProduct->legend|escape:html:'UTF-8'}" />
                    </a>
                <h2 class="product-name"><a href="{$viewedProduct->product_link}" title="{l s='About' mod='blockviewed'} {$viewedProduct->name|escape:html:'UTF-8'}">{$viewedProduct->name|truncate:14:'...'|escape:html:'UTF-8'}</a></h2>
                <div class="price-box">
                    {$viewedProduct->description_short|strip_tags:'UTF-8'|truncate:44}
                </div>
            </li>
              {/foreach} 
        </ul>
        
        <script type="text/javascript">
            $jq(document).ready(function() {						
            $jq('#ma-new-vertscroller-left').jcarousel({
            vertical: true,
            wrap: 'circular',
            auto: 0,
            animation: 1000,
            scroll: 1						});
        $jq(".ma-new-vertscroller-wrap .jcarousel-container-vertical, .ma-new-vertscroller-wrap .jcarousel-clip-vertical")
        .css("width","172px")
        .css("height","300px");							
    });
        </script>
    </div>		
</div>               







