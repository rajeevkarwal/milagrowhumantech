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
<h3>{l s='Cash on delivery (COD) payment' mod='cod'}</h3>

<form action="{$link->getModuleLink('cod', 'validation', [], true)}" method="post">
	<input type="hidden" name="confirm" value="1" />
	<div class="cod-text">
		<img src="{$this_path}cod.jpg" alt="{l s='Cash on delivery (COD) payment' mod='cod'}" style="float:left; margin: 0px 10px 25px 0px;" />
		{l s='You have chosen the cash on delivery method.' mod='cod'}
		{l s='The total amount of your order is' mod='cod'}
		<span id="amount_{$currencies.0.id_currency}" class="price">{convertPrice price=$total}</span>
		{if $use_taxes == 1}
		    {l s='(tax incl.)' mod='cod'}
		{/if}
		<p><br/>You will have to pay an amount of Rs 500 which will be deducted from your bill as advance payment for Cash on Delivery.
           <br/><br/>You will be redirected to the payment gateway from here. <b>{l s='Please confirm your order by clicking \' Pay Now \'' mod='cod'}.</b></p>

	</div>
	<p class="cart_navigation">
		<input type="submit" name="submit" value="{l s=' Pay Now ' mod='cod'}" class="exclusive_large" /><br/><br/>
        <a href="{$link->getPageLink('order', true)}?step=3" class="button_large">{l s='Other payment methods' mod='cod'}</a>
	</p>
</form>
</div>