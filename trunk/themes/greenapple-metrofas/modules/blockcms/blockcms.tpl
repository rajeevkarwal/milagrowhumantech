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




{if $block == 1}
    <!-- Block CMS module -->
    {foreach from=$cms_titles key=cms_key item=cms_title}
        <div id="informations_block_left_{$cms_key}" class="block block-list block-layered-nav block-verticalmenu">

            <div class="block-title">
                <strong style=""><span>{if !empty($cms_title.name)}{$cms_title.name}{else}{$cms_title.category_name}{/if}</span></strong>
            </div>
            <div class="block-content left-categorys-container">   
                <ul  id="ma-accordion"  class="block_content accordion">
                    {foreach from=$cms_title.categories item=cms_page}
                        {if isset($cms_page.link)}<li class="bullet"><b style="margin-left:2em;">
                                    <a href="{$cms_page.link}" title="{$cms_page.name|escape:html:'UTF-8'}">{$cms_page.name|escape:html:'UTF-8'}</a>
                                </b></li>{/if}
                                {/foreach}
                                    {foreach from=$cms_title.cms item=cms_page}
                                    {if isset($cms_page.link)}<li><a href="{$cms_page.link}" title="{$cms_page.meta_title|escape:html:'UTF-8'}">{$cms_page.meta_title|escape:html:'UTF-8'}</a></li>{/if}
                            {/foreach}
                        {if $cms_title.display_store}<li><a href="{$link->getPageLink('stores')}" title="{l s='Our stores' mod='blockcms'}">{l s='Our stores' mod='blockcms'}</a></li>{/if}
                    </ul>

                </div> 

            </div>
            {/foreach}
                <!-- /Block CMS module -->
                {else}
      
                                            <div class="span3 fcol1">
                                                <div class="footer-static-title">
                                                    <h3>{l s='Other Links' mod='blockcms'}</h3>
                                                </div>
                                                <div class="footer-static-content">
                                                    <ul>
                                                    {if !$PS_CATALOG_MODE}{*<li ><a href="{$link->getPageLink('prices-drop')}" title="{l s='Specials' mod='blockcms'}">{l s='Specials' mod='blockcms'}</a></li>*}{/if}
                                                    {*<li ><a href="{$link->getPageLink('new-products')}" title="{l s='New products' mod='blockcms'}">{l s='New products' mod='blockcms'}</a></li>*}
                                                {if !$PS_CATALOG_MODE}{*<li ><a href="{$link->getPageLink('best-sales')}" title="{l s='Top sellers' mod='blockcms'}">{l s='Top sellers' mod='blockcms'}</a></li>*}{/if}
                                            {if $display_stores_footer}{*<li ><a href="{$link->getPageLink('stores')}" title="{l s='Our stores' mod='blockcms'}">{l s='Our stores' mod='blockcms'}</a></li>*}{/if}
                                            {*<li><a href="{$link->getPageLink($contact_url, true)}" title="{l s='Contact us' mod='blockcms'}">{l s='Contact us' mod='blockcms'}</a></li>*}
                                            {foreach from=$cmslinks item=cmslink}
                                                {if $cmslink.meta_title != ''}
                                                    <li ><a href="{$cmslink.link|addslashes}" title="{$cmslink.meta_title|escape:'htmlall':'UTF-8'}">{$cmslink.meta_title|escape:'htmlall':'UTF-8'}</a></li>
                                                {/if}
                                            {/foreach}
                                            <li><a href="{$link->getPageLink('sitemap')}" title="{l s='sitemap' mod='blockcms'}">{l s='Sitemap' mod='blockcms'}</a></li>
                                        </ul>
                                        {$footer_text}
                                    </div>
                                </div>
                                <!-- /MODULE Block footer -->
                                {/if}





