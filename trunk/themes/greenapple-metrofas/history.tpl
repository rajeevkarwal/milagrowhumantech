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
<style>
    .color-myaccount {
        cursor: pointer;
        color: #ffa930;
    }
</style>

<link href="/js/jquery/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="/js/jquery/plugins/fancybox/jquery.fancybox.js"></script>
{capture name=path}<a href="{$link->getPageLink('my-account', true)}">{l s='My account'}</a><span
        class="navigation-pipe">{$navigationPipe}</span>{l s='Order history'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<div class="clearer"></div>
{include file="$tpl_dir./errors.tpl"}

<div class="main">
    <div class="main-inner">
        <div class="col-main">
            <div class="account-login">
                <div class="page-title">
                    <h1>{l s='Order history'}</h1>
                </div>
                <p class="cms-banner-img"><img src="/img/cms/cms-banners/track-order.png"
                                               alt="milagrow-trackorder-banner"></p>
                {include file="$tpl_dir./errors.tpl"}

                <p class='headdingtitle'>{l s='Here are the orders you have placed since the creation of your account'}
                    .</p>

                {if $slowValidation}<p
                        class="warning">{l s='If you have just placed an order, it may take a few minutes for it to be validated. Please refresh this page if your order is missing.'}</p>{/if}

                <div class="block-center" id="block-history">
                    {if $orders && count($orders)}
                        <table class="data-table cart-table" id="shopping-cart-table">
                            <colgroup>
                                <col width="1">
                                <col>
                                <col width="1">
                                <col width="1">
                                <col width="1">
                                <col width="1">
                                <col width="1">
                            </colgroup>
                            <thead>
                            <tr class="first last">
                                <th rowspan="1">{l s='Order Reference'}</th>
                                <th rowspan="1"><span class="nobr">{l s='Date'}</span></th>
                                {*<th rowspan="1">{l s='Total price'}</th>*}
                                <th colspan="1" class="a-center"><span class="nobr">{l s='Payment'}</span></th>
                                <th class="a-center" rowspan="1">{l s='Status'}</th>
                                <th colspan="1" class="a-center">{l s='Invoice'}</th>
                                <th class="a-center" rowspan="1">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$orders item=order name=myLoop}
                                <tr id="{$order.id_order|intval}"
                                    class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
                                    <td class="history_link bold">
                                        {if isset($order.invoice) && $order.invoice && isset($order.virtual) && $order.virtual}
                                            <img src="{$img_dir}icon/download_product.gif" class="icon"
                                                 alt="{l s='Products to download'}"
                                                 title="{l s='Products to download'}" />{/if}
                                        <a class="color-myaccount"
                                           href="javascript:showOrder(1, {$order.id_order|intval}, '{$link->getPageLink('order-detail', true)}');">{Order::getUniqReferenceOf($order.id_order)}</a>
                                    </td>
                                    <td class="history_date bold">{dateFormat date=$order.date_add full=0}</td>
                                    {*<td class="history_price"><span*}
                                    {*class="price">{displayPrice price=$order.total_paid currency=$order.id_currency no_utf8=false convert=false}</span>*}
                                    {*</td>*}
                                    <td class="history_method">{$order.payment|escape:'htmlall':'UTF-8'}</td>
                                    <td class="history_state">{if isset($order.order_state)}{$order.order_state|escape:'htmlall':'UTF-8'}{/if}</td>
                                    <td class="history_invoice">
                                        {if (isset($order.invoice) && $order.invoice && isset($order.invoice_number) && $order.invoice_number) && isset($invoiceAllowed) && $invoiceAllowed == true}
                                            <a href="{$link->getPageLink('pdf-invoice', true, NULL, "id_order={$order.id_order}")}"
                                               title="{l s='Invoice'}" target="_blank"><img src="{$img_dir}icon/pdf.gif"
                                                                                            alt="{l s='Invoice'}"
                                                                                            class="icon"/></a>
                                            <a href="{$link->getPageLink('pdf-invoice', true, NULL, "id_order={$order.id_order}")}"
                                               title="{l s='Invoice'}" target="_blank">{l s='PDF'}</a>
                                        {else}-{/if}
                                    </td>
                                    <td class="history_detail">
                                        <span class="color-myaccount"
                                              onclick="javascript:showOrder(1, {$order.id_order|intval}, '{$link->getPageLink('order-detail', true)}');">{l s='details'}</span>

                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                        <div id="block-order-detail" class="tophidden">&nbsp;</div>
                    {else}
                        <p class="warning">{l s='You have not placed any orders.'}</p>
                    {/if}
                </div>
                <div class="headdingtitle"></div>
                <ul class="footer_links clearfix">
                    <li><a href="{$link->getPageLink('my-account', true)}"><img src="{$img_dir}icon/my-account.gif"
                                                                                alt=""
                                                                                class="icon"/> {l s='Back to Your Account'}
                        </a></li>
                    <li class="f_right"><a href="{$base_dir}"><img src="{$img_dir}icon/home.gif" alt=""
                                                                   class="icon"/> {l s='Home'}</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        $('#shopping-cart-table tbody tr').each(function () {
            var $this = $(this);
            var currentRowOrderId = $(this).attr('id');
            var currentRowTd = $this.find('.history_state');
            var val = currentRowTd.text();
            if (val == 'shipped' || val == 'Shipped') {
                var formattedURL = baseDir + 'modules/frontorder/track/track.php?order_id=' + currentRowOrderId;
                $.ajax({
                    type: 'POST',
                    url: formattedURL,
                    success: function (data) {
                        if (data.carrier == 'FDX') {
                            currentRowTd.html('<p>Shipped <a href="' + data.url + '" class="' + data.carrier + '" id="' + data.trackingNumber + '">[Track]</a></p>');
                            callFancybox();
                        }
                        else {
                            currentRowTd.html('<p>Shipped <a href="' + data.url + '" target="_blank">[Track]</a></p>');
                        }

                    },
                    dataType: 'json'
                });

            }

        });
        function callFancybox() {
            var fancyBoxObj = new Object();
            fancyBoxObj.width = 660;
            fancyBoxObj.height = 800;
            fancyBoxObj.scrolling = 'no';
            fancyBoxObj.autoDimensions = true;
            fancyBoxObj.transitionIn = 'none';
            fancyBoxObj.transitionOut = 'none';
            fancyBoxObj.type = 'iframe';
            $('a.FDX').fancybox(fancyBoxObj);
        }
    })
</script>
<!-- END page -->
