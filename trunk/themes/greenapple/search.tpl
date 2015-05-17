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




    {capture name=path}{l s='Search'}{/capture}
    {include file="$tpl_dir./breadcrumb.tpl"}
    
<div class="main-container col2-left-layout" >
    <div class="main">
        <div class="col-main">
            <div class="page-title">
                {if $nbProducts} 
                    <a href="{$link->getPageLink('products-comparison')}" title="" class="compaate_button">{l s='Compare'}</a>
                {/if}
                <h1 {if isset($instantSearch) && $instantSearch}id="instant_search_results"{/if}>
    {l s='Search'}&nbsp;{if $nbProducts > 0}"{if isset($search_query) && $search_query}{$search_query|escape:'htmlall':'UTF-8'}{elseif $search_tag}{$search_tag|escape:'htmlall':'UTF-8'}{elseif $ref}{$ref|escape:'htmlall':'UTF-8'}{/if}"{/if}
{if isset($instantSearch) && $instantSearch}<a href="#" class="close">{l s='Return to the previous page'}</a>{/if}
</h1>
</div>  


<div class="category-products">

    {include file="$tpl_dir./errors.tpl"}
    {if !$nbProducts}
        <p class="warning">
            {if isset($search_query) && $search_query}
            {l s='No results were found for your search'}&nbsp;"{if isset($search_query)}{$search_query|escape:'htmlall':'UTF-8'}{/if}"
        {elseif isset($search_tag) && $search_tag}
            {l s='No results were found for your search'}&nbsp;"{$search_tag|escape:'htmlall':'UTF-8'}"
        {else}
            {l s='Please enter a search keyword'}
        {/if}
    </p>
{else}

    <h3 class="nbresult"><span class="big">{if $nbProducts == 1}{l s='%d result has been found.' sprintf=$nbProducts|intval}{else}{l s='%d results have been found.' sprintf=$nbProducts|intval}{/if}</span></h3>

    {if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}

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
                {if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}{include file="$tpl_dir./pagination.tpl"}{/if}
            </div>
            <div class="limiter">

            </div>
        </div>
    </div>      
    {include file="$tpl_dir./product-list.tpl" products=$search_products}         
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
                {if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}{include file="$tpl_dir./pagination.tpl"}{/if}
            </div>
            <div class="limiter">

            </div>
        </div>
    </div>
</div>


{/if}







{/if}

</div>


</div>
<div class="col-left sidebar">
    {$HOOK_LEFT_COLUMN}
    <div class="block">
        {$dedalx.metro_left_sidebar_customhtml|html_entity_decode}
    </div>

</div>
</div>
</div>



