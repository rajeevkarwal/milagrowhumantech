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
<script type="text/javascript">
    $(document).ready(function () {
        $('.cod_disable').click(function (e) {
            e.preventDefault();
            var content = $('#fancybox-address-error').html();
            $.fancybox(content);

        });
        $('a.iframe').fancybox();
    })
</script>
{if $cod_available==1}
    <div class="payment-main-block">
        <div class="payment-text-block">
            <span>Cash on Delivery (COD) <a href="content/35-cash-on-delivery?content_only=1" class="iframe"><img
                            src="{$module_dir}img/question_icon.gif"/></a><br/>
        <span class="payment-description">Pay some advance and rest at time of delivery</span>
        </div>
        <div class="payment-button-block">
            <button class="exclusive_large"
                    onclick="location.href='{$link->getModuleLink('cod', 'validation', [], true)}'">Confirm Payment
            </button>
        </div>
    </div>
{else}
    <div class="payment-main-block">
        <div class="payment-text-block">
            <span>Cash on Delivery (COD) <a href="content/35-cash-on-delivery?content_only=1" class="iframe"><img
                            src="{$module_dir}img/question_icon.gif"/></a><br/>
        <span class="payment-description">Pay some advance and rest at time of delivery</span>
        </div>
        <div class="payment-button-block">
            <button class="exclusive_large cod_disable">Confirm Payment</button>
        </div>
    </div>
    <div id="fancybox-address-error" style="display: none">
        {if $error_case=='address_error'}
            <p>Sorry, currently we are not providing COD service to address you have chosen for delivery.</p>
            <p>Please choose a different payment option or update address and after correcting the address, proceed to checkout again.
            </p>
            <p>
                Errors in following addresses:
            </p>
            {foreach $addressErrors as $row}
                <p><a href="/address?id_address={$row->id}&back=order.php?step=1">Click here to change address with
                        pincode {$row->postcode}</a></p>
            {/foreach}

        {elseif $error_case=='product_count_error'}
            <p>Sorry, currently we are not providing Cash on Delivery service on more than one products.</p>
            <p>Please choose a different payment option or update your cart and proceed to checkout again.
            </p>
            <p>You may also choose to place separate orders in case you wish to order more than one item on Cash on Delivery.
            </p>


        {elseif $error_case=='order_total_error'}
            <p>Sorry, currently we are not providing Cash on Delivery service on orders below Rs 2000.</p>
            <p>Please choose a different payment option and proceed to checkout again.
            </p>
        {elseif $error_case=='quantity_error'}
            <p>Sorry, currently we are not providing Cash on Delivery service on Pre Order items.</p>
        {/if}
    </div>
{/if}

