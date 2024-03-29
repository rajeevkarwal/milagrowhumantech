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

        {include file="$tpl_dir./breadcrumb.tpl"}
        <div class="clear"></div>
        {include file="$tpl_dir./errors.tpl"}
    <div class="main-container col2-left-layout">
        <div class="main">
            <div class="col-main">
                {if !isset($errors) OR !sizeof($errors)}
                    <div class="page-title">
                        <h1>{l s='List of products by supplier:'}&nbsp;{$supplier->name|escape:'htmlall':'UTF-8'}</h1>
                    </div>
                    {if !empty($supplier->description)}
                        <div class="description_box">
                            <p>{$supplier->description}</p>
                        </div>
                    {/if}



                    <div class="category-products">
                        {if $products}

                            <div class="toolbar">
                                <div class="pager">
                                    <div class="sort-by">
                                        {include file="./product-sort.tpl"}

                                    </div>
                                    <p class="view-mode">
                                        <label>{l s='View as:'}</label>
                                        <strong title="{l s='Grid'}" class="grid">{l s='Grid'}</strong>
                                        <a href="#" title="{l s='List'}" class="list">{l s='List'}</a>
                                    </p>
                                    <div class="pages">
                                        {include file="$tpl_dir./pagination.tpl"}
                                    </div>
                                    <div class="limiter">
                                        {include file="./nbr-product-page.tpl"}
                                    </div>
                                </div>
                            </div>      
                            {include file="./product-list.tpl" products=$products}           
                            <div class="toolbar-bottom">
                                <div class="toolbar">
                                    <div class="pager">
                                        <div class="sort-by">
                                            {include file="./product-sort.tpl"}

                                        </div>
                                        <p class="view-mode">
                                            <label>{l s='View as:'}</label>
                                            <strong title="{l s='Grid'}" class="grid grid-active">{l s='Grid'}</strong>
                                            <a href="#" title="{l s='List'}" class="list">{l s='List'}</a>
                                        </p>
                                        <div class="pages">
                                            {include file="$tpl_dir./pagination.tpl"}
                                        </div>
                                        <div class="limiter">
                                            {include file="./nbr-product-page.tpl"}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {else}
                            <p class="warning">{l s='No products for this supplier.'}</p>
                        {/if} 

                    </div>   

                {/if}



            </div>
            <div class="col-left sidebar">
                {$HOOK_LEFT_COLUMN}
                <div class="block">
                    {$dedalx.metro_left_sidebar_customhtml|html_entity_decode}
                </div>

            </div>
        </div>
    </div>


