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
{capture name=path}{l s='Top sellers'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

        <div class="main">
            <div class="main-inner">
                <div class="row-fluid show-grid">
                     {if $themesdev.td_siderbar_without=="enable"}
                    <div class="col-left sidebar span3">
                        {$HOOK_LEFT_COLUMN}
                        {$themesdev.td_left_sidebar_customhtml|html_entity_decode}
                    </div>
                    {/if}
                    <div class="{if $themesdev.td_siderbar_without=="enable"}col-main span9{else}std{/if}">
                        <div class="page-title">
                          
                            <h1>{l s='Top sellers'}</h1>
                        </div>  
                        <div class="category-products">
                            {if $products}
                                <div class="toolbar">
                                    <div class="pager">
                                        <p class="view-mode">
                                            <label>{l s='View as:'}</label>
                                            <span>
                                                <strong title="{l s='Grid'}" class="grid">{l s='Grid'}</strong>
                                            </span>
                                            <span>
                                                <a href="#" title="{l s='List'}" class="list">{l s='List'}</a>
                                            </span>
                                        </p>
                                        <div class="sort-by hidden-phone">
                                            {include file="./product-sort.tpl"}

                                        </div>

                                        <div class="pages">
                                            {include file="$tpl_dir./pagination.tpl"}
                                        </div>
                                        <div class="limiter visible-desktop">
                                            {include file="./nbr-product-page.tpl"}
                                        </div>
                                    </div>
                                </div>      
                                {include file="./product-list.tpl" products=$products}           
                                <div class="toolbar-bottom">
                                    <div class="toolbar">
                                        <div class="pager">
                                            <p class="view-mode">
                                                <label>{l s='View as:'}</label>
                                                <span>
                                                    <strong title="{l s='Grid'}" class="grid grid-active">{l s='Grid'}</strong>
                                                </span>
                                                <span>
                                                    <a href="#" title="{l s='List'}" class="list">{l s='List'}</a>
                                                </span>
                                            </p>
                                            <div class="sort-by hidden-phone">
                                                {include file="./product-sort.tpl"}
                                            </div>

                                            <div class="pages">
                                                {include file="$tpl_dir./pagination.tpl"}
                                            </div>
                                            <div class="limiter visible-desktop">
                                                {include file="./nbr-product-page.tpl"}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            {else}
                                <p class="warning">{l s='No top sellers for the moment.'}</p>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>






