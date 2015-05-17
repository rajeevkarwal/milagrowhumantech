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


<!-- /Block user information module HEADER -->
<div id="cart" class="mm_shopcart" onclick="location.href='{$link->getPageLink($order_process, true)}'">
    <div class="heading">
        <div class="block block-cart-header">
            <div class="block-content">
                {if !$PS_CATALOG_MODE}
                    <span class="button-show">
                        <ul id="header_nav">
                            <li id="shopping_cart">
                                <a href="{$link->getPageLink($order_process, true)}" title="{l s='Your Shopping Cart' mod='blockuserinfo'}">
                                    <span class="shop-total">{l s='Shopping Cart-' mod='blockuserinfo'}
                                        <span class="ajax_cart_total{if $cart_qties == 0} tophidden{/if} price">
                                            {if $cart_qties > 0}
                                                {if $priceDisplay == 1}
                                                    {assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
                                                    {convertPrice price=$cart->getOrderTotal(false, $blockuser_cart_flag)}
                                                {else}
                                                    {assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
                                                    {convertPrice price=$cart->getOrderTotal(true, $blockuser_cart_flag)}
                                                {/if}
                                            {/if}
                                        </span>
                                        <span class="ajax_cart_no_product{if $cart_qties > 0} tophidden{/if} price"> {assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
                                            {convertPrice price=$cart->getOrderTotal(false, $blockuser_cart_flag)}</span>
                                    </span>
                                </a>
                            </li>
                        </ul>       
                    </span>

                {/if} 


               