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
{if ($content_only == 0)}
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

            {/if}



            <div class="{if $themesdev.td_siderbar_without=="enable"}col-main span9{else}std{/if}">
                <form class="std">

                    <h1 style="font-size: 26px;margin-bottom: 20px; >
                            <a href="{if $cms_category->id eq 1}{$base_dir}{else}{$link->getCMSCategoryLink($cms_category->id, $cms_category->link_rewrite)}{/if}
                    ">{$cms_category->name|escape:'htmlall':'UTF-8'}</a>
                    </h1>
				

                    <h1 style="font-size: 26px;margin-bottom: 10px;margin-top: -20px; text-align: left;">{$cms->meta_title}</h1>

                    <fieldset>

                        {if isset($cms) && !isset($cms_category)}
                            {if !$cms->active}
                                <br/>
                                <div id="admin-action-cms">
                                    <p>{l s='This CMS page is not visible to your customers.'}
                                        <input type="hidden" id="admin-action-cms-id" value="{$cms->id}"/>
                                        <input type="submit" value="{l s='Publish'}" class="exclusive"
                                               onclick="submitPublishCMS('{$base_dir}{$smarty.get.ad|escape:'htmlall':'UTF-8'}', 0, '{$smarty.get.adtoken|escape:'htmlall':'UTF-8'}')"/>
                                        <input type="submit" value="{l s='Back'}" class="exclusive"
                                               onclick="submitPublishCMS('{$base_dir}{$smarty.get.ad|escape:'htmlall':'UTF-8'}', 1, '{$smarty.get.adtoken|escape:'htmlall':'UTF-8'}')"/>
                                    </p>

                                    <div class="clear"></div>
                                    <p id="admin-action-result"></p>
                                    </p>
                                </div>
                            {/if}
                            <div class="rte{if $content_only} content_only{/if}">
                                {$cms->content}
                            </div>
                        {elseif isset($cms_category)}
                            <div class="block-cms">

                                {*<h1>
                                    <a href="{if $cms_category->id eq 1}{$base_dir}{else}{$link->getCMSCategoryLink($cms_category->id, $cms_category->link_rewrite)}{/if}">{$cms_category->name|escape:'htmlall':'UTF-8'}</a>
                                </h1>*}
                                {if isset($sub_category) & !empty($sub_category)}
                                {*<p class="title_block">{l s='List of sub categories in %s:' sprintf=$cms_category->name}</p>*}
                                    <ul class="bullet">
                                        {foreach from=$sub_category item=subcategory}
                                            <li class="cms-list">
                                                <span class="arrow-cms-list">&raquo;</span> <a
                                                        href="{$link->getCMSCategoryLink($subcategory.id_cms_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}">{$subcategory.name|escape:'htmlall':'UTF-8'}</a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                {/if}
                                {if isset($cms_pages) & !empty($cms_pages)}
                                {*<p class="title_block">{l s='List of pages in %s:' sprintf=$cms_category->name}</p>*}
                                    <ul class="bullet">
                                        {foreach from=$cms_pages item=cmspages}
                                            <li class="cms-list">
                                                <span class="arrow-cms-list">&raquo;</span> <a
                                                        href="{$link->getCMSLink($cmspages.id_cms, $cmspages.link_rewrite)|escape:'htmlall':'UTF-8'}">{$cmspages.meta_title|escape:'htmlall':'UTF-8'}</a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                {/if}
                            </div>
                        {else}
                            <div class="error">
                                {l s='This page does not exist.'}
                            </div>
                        {/if}
                        <br/>

                    </fieldset>
                </form>

            </div>
            {if ($content_only == 0)}
        </div>
    </div>
</div>
{/if}


<script type="text/javascript" charset="utf-8">
  $jq(window).load(function() {
    $jq('.flexsliderCms').flexslider(
            {
            animation: "slide",
            slideshowSpeed: 7000,
            animationSpeed: 600
                        }
    );
	$('.no_pre_product').click(function(e){
	   
	   alert("Sorry! There are no products in Pre-launch currently.");
	});
	
  });
</script>

<style type="text/css">
    .flexsliderCms .flex-direction-nav{
        display: none;
    }

</style>
