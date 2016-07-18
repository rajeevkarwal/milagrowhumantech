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
{capture name=path}{l s='My account'}{/capture}
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

            <div class="span9 page-title">
                <h1>{l s='My account'}</h1>
            </div>
            <div class="{if $themesdev.td_siderbar_without=="enable"}col-main span9 cms-banner{else}std{/if}">

                <p class="cms-banner-img"><img src="/img/cms/cms-banners/my-account.png" alt="milagrow-my-accounts"></p>
                <div class="category-products my-account-area">
                    {if isset($account_created)}
                        <p class="success">
                            {l s='Your account has been created.'}
                        </p>
                    {/if}

                    <p class="title_block">{l s='Welcome to your account. Here you can manage al of your personal information and orders. '}</p>
                    <ul class="myaccount_lnk_list">
                        {if $has_customer_an_address}
                            <li><a href="{$link->getPageLink('address', true)}"
                                   title="{l s='Add my first address'}"><img src="{$img_dir}icon/addrbook.gif"
                                                                             alt="{l s='Add my first address'}"
                                                                             class="icon"/> {l s='Add my first address'}
                                </a></li>
                        {/if}
                        <li><a href="{$link->getPageLink('history', true)}" title="{l s='Orders'}"><img
                                        src="{$img_dir}icon/order.gif" alt="{l s='Orders'}"
                                        class="icon"/> {l s='Order history and details '}</a></li>
                        {if $returnAllowed}
                            <li><a href="{$link->getPageLink('order-follow', true)}"
                                   title="{l s='Merchandise returns'}"><img src="{$img_dir}icon/return.gif"
                                                                            alt="{l s='Merchandise returns'}"
                                                                            class="icon"/> {l s='My merchandise returns'}
                                </a></li>
                        {/if}
                        {*<li><a href="{$link->getPageLink('order-slip', true)}" title="{l s='Credit slips'}"><img src="{$img_dir}icon/slip.gif" alt="{l s='Credit slips'}" class="icon" /> {l s='My credit slips'}</a></li>*}
                        <li><a href="{$link->getPageLink('addresses', true)}" title="{l s='Addresses'}"><img
                                        src="{$img_dir}icon/addrbook.gif" alt="{l s='Addresses'}"
                                        class="icon"/> {l s='My addresses'}</a></li>
                        <li><a href="{$link->getPageLink('identity', true)}" title="{l s='Information'}"><img
                                        src="{$img_dir}icon/userinfo.gif" alt="{l s='Information'}"
                                        class="icon"/> {l s='My personal information'}</a></li>
                        {if $voucherAllowed}
                            <li><a href="{$link->getPageLink('discount', true)}" title="{l s='Vouchers'}"><img
                                            src="{$img_dir}icon/voucher.gif" alt="{l s='Vouchers'}"
                                            class="icon"/> {l s='My vouchers'}</a></li>
                        {/if}
                        {$HOOK_CUSTOMER_ACCOUNT}
                        <li><a href="{$base_dir}" title="{l s='Home'}"><img src="{$img_dir}icon/home.gif"
                                                                            alt="{l s='Home'}" class="icon"/></a><a
                                    href="{$base_dir}" title="{l s='Home'}">{l s='Home'}</a>
                        </li>
                    </ul>

                </div>
            </div>


        </div>
    </div>

</div>

<!-- Google Code for MilagrowHumantech Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968875551;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "VZV0CJnS7xEQn7z_zQM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/968875551/?label=VZV0CJnS7xEQn7z_zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
