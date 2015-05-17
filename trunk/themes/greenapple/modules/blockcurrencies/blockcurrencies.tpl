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

<!-- Block currencies module -->
<script type="text/javascript">
$(document).ready(function () {
	$("#setCurrency").mouseover(function(){
		$(this).addClass("countries_hover");
		$(".currencies_ul").addClass("currencies_ul_hover");
	});
	$("#setCurrency").mouseout(function(){
		$(this).removeClass("countries_hover");
		$(".currencies_ul").removeClass("currencies_ul_hover");
	});

	$('ul#first-currencies li:not(.selected)').css('opacity', 0.3);
	$('ul#first-currencies li:not(.selected)').hover(function(){
		$(this).css('opacity', 1);
	}, function(){
		$(this).css('opacity', 0.3);
	});
});
</script>

                   

<div class="currency">
   {if count($currencies) > 1}  
    {foreach from=$currencies key=k item=f_currency}
        {if $cookie->id_currency == $f_currency.id_currency}
            <span title="{$f_currency.name}" class="currency-code" >{$f_currency.name}</span>
        {else}
             <a href="javascript:setCurrency({$f_currency.id_currency});" class="currency-code"  title="{$f_currency.name}">{$f_currency.name}</a>
       {/if}
    {/foreach}
  {/if} 
  </div>
  
{if $logged}
        {l s='Welcome' mod='blockcurrencies'} <a href="{$link->getPageLink('my-account', true)}" >({$cookie->customer_lastname})</a>
         <a href="{$link->getPageLink('index', true, NULL, "mylogout")}" title="{l s='Log me out' mod='blockcurrencies'}">{l s='Log out' mod='blockcurrencies'}</a>
   {else}
       {l s='Welcome visitor you can' mod='blockcurrencies'} <a href="{$link->getPageLink('my-account', true)}">{l s='login' mod='blockcurrencies'}</a> or <a href="{$link->getPageLink('my-account', true)}">{l s='create an account' mod='blockcurrencies'}</a>
  {/if}
              
<!-- /Block currencies module -->
