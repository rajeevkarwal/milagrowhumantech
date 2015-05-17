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

{capture name=path}{l s='Cash on Delivery' mod='cod'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

{*<h2>{l s='Order summation' mod='cod'}</h2>*}


{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}
<div class="cod-content">

    {if $error_at_cod}
        <h3>{l s='Cash on delivery (COD) payment' mod='cod'}</h3>
        <p class="cod_error">
            <br>
            Sorry,<br><br>
            The maximum order value for a Cash on Delivery (COD) payment at Milagrow is INR 20,000.<br>
            Since your current order exceeds INR 20,000, we recommend you to split your order. <br> Please note that you
            will be required to
            pay Rs. 750/- as a nominal non-refundable advance to cover for the to and fro freight cost on each
            product.
            <br>
            <br>
            <br>
        </p
    {else}
        <h3>{l s='Cash on delivery (COD) payment' mod='cod'}</h3>
        <p>You have chosen cash on delivery method, the total amount for your order is <span
                    id="amount_{$currencies.0.id_currency}" class="price">{convertPrice price=$total}</span>
            {if $use_taxes == 1}
                {l s='(tax incl.)' mod='cod'}
            {/if} </span> and you will have to pay <span id="amount_{$currencies.0.id_currency}"
                                                         class="price"><strong>{convertPrice price=$totalAdvance}</strong></span>

        </p>
        <p>You will have to confirm your order by clicking Pay Now button and you will be redirected to payment gateway
            to
            complete the payment process</p>
        <p>Table showing details of your order divided on basis of delivery options and carriers selected:</p>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width:55%">Order Details:</th>
                <th style="width:15%">Total Order Amount {if $use_taxes == 1}
                        <br>
                        {l s='(tax incl.)' mod='cod'}
                    {/if}</th>
                <th style="width:15%">Advance for COD {if $use_taxes == 1}
                        <br>
                        {l s='(tax incl.)' mod='cod'}
                    {/if}</th>
                <th style="width:15%">Cash to be paid at delivery {if $use_taxes == 1}
                        <br>
                        {l s='(tax incl.)' mod='cod'}
                    {/if}</th>

            </tr>
            </thead>
            <tbody>
            {foreach $codStatus as $key=>$CODentry}
                <tr>
                    <td row-span="{count($CODentry['product'])}">
                        <strong>OrderNo.{$key+1}</strong>
                        <table>
                            <thead style="border-top: 1px solid #ccc;
border-right: 1px solid #ccc;">
                            <tr>
                                <th>Product List</th>
                                <th>Product Price</th>
                                <th>Quantity</th>
                                {*<th>Advance Amount</th>*}
                                {*not to use advance amount as shipping and other wrapping cost not available.*}
                                {*<th>Amount to be paid at delivery</th>*}
                                <th>COD Status</th>
                            </tr>
                            </thead>
                            <tbody style="border-bottom: 1px solid #ccc;
border-right: 1px solid #ccc;">
                            {foreach $CODentry['product'] as $product }
                                <tr>
                                    <td>{$product['name']}</td>
                                    <td>{$product['price']}</td>
                                    <td>{$product['quantity']}</td>
                                    {*<td><span id="amount_{$currencies.0.id_currency}"*}
                                    {*class="price">{convertPrice price=$product['productCOD']}</span>*}
                                    {*</span></td>*}
                                    {*<td><span id="amount_{$currencies.0.id_currency}"*}
                                    {*class="price">{convertPrice price=$product['balanceAmount']}</span>*}
                                    {*</span></td>*}
                                    <td style="color: {if $product['codStatus']}green{else}red{/if}">{if $product['codStatus']}COD Available{else}COD Not Available{/if}</td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>

                    </td>
                    {*<td>{$CODentry['orderTotal']}</td>*}
                    <td><span id="amount_{$currencies.0.id_currency}"
                              class="price">{convertPrice price=$CODentry['orderTotal']}</span>
                        </span></td>
                    <td><span id="amount_{$currencies.0.id_currency}"
                              class="price">{convertPrice price=$CODentry['advanceAmount']}</span>
                        </span></td>
                    <td><span id="amount_{$currencies.0.id_currency}"
                              class="price">{convertPrice price=$CODentry['balanceCOD']}</span>
                        </span></td>


                </tr>
            {/foreach}
            <tr>
                <td></td>
                <td></td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price"><strong>{convertPrice price=$totalAdvance}</strong></span>
                    </span></td>
                <td><span id="amount_{$currencies.0.id_currency}"
                          class="price"><strong>{convertPrice price=$totalAtCOD}</strong></span>
                    </span></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <form action="{$link->getModuleLink('cod', 'validation', [], true)}" method="post">
            <input type="hidden" name="confirm" value="1"/>

            {*<div class="cod-text">*}
            {*<img src="{$this_path}cod.jpg" alt="{l s='Cash on delivery (COD) payment' mod='cod'}"*}
            {*style="float:left; margin: 0px 10px 25px 0px;"/>*}
            {*{l s='You have chosen the cash on delivery method.' mod='cod'}*}
            {*{l s='The total amount of your order is' mod='cod'}*}

            {*<p><br/>You will have to pay an amount of Rs 500 which will be deducted from your bill as advance*}
            {*payment*}
            {*for Cash on Delivery.*}
            {*<br/><br/>You will be redirected to the payment gateway from here.*}
            {*<b>{l s='Please confirm your order by clicking \' Pay Now \'' mod='cod'}.</b></p>*}

            {*</div>*}
            <p class="cart_navigation pull-right">
                <input type="submit" name="submit" value="{l s=' Pay Now ' mod='cod'}"
                       class="exclusive_large"/><br/><br/>
            </p>
            <a href="{$link->getPageLink('order', true)}?step=3"
               class="button_large">{l s='Other payment methods' mod='cod'}</a>

        </form>
    {/if}

</div>

