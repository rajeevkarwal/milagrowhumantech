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

<div class="main">
    <link href="/js/jquery/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all">
    <script type="text/javascript" src="/js/jquery/plugins/fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var ids = $(".item-inner").map(function () {
                return this.id;
            });
            //array of ids
            var idsArray = ids.toArray();
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
            $('a.iframe').fancybox();
        });
    </script>
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
                    <h1 {if isset($instantSearch) && $instantSearch}id="instant_search_results"{/if}>
                        {l s='Search'}
                        &nbsp;{if $nbProducts > 0}"{if isset($search_query) && $search_query}{$search_query|escape:'htmlall':'UTF-8'}{elseif $search_tag}{$search_tag|escape:'htmlall':'UTF-8'}{elseif $ref}{$ref|escape:'htmlall':'UTF-8'}{/if}"{/if}
                        {if isset($instantSearch) && $instantSearch}<a href="#"
                                                                       class="close">{l s='Return to the previous page'}</a>{/if}
                    </h1>
                </div>

                <div id="compare_block">
                    <div class="block_content" id="fc_comparison">
                    </div>
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
                        <h3 class="nbresult"><span
                                    class="big">{if $nbProducts == 1}{l s='%d result has been found.' sprintf=$nbProducts|intval}{else}{l s='%d results have been found.' sprintf=$nbProducts|intval}{/if}</span>
                        </h3>
                        {if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}
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
                            {include file="./product-list.tpl" products=$search_products}
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
                        {/if}







                    {/if}

                </div>


            </div>

        </div>
    </div>


</div>



