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
<div class="payment-main-block" style="display: none;" id="bankwire_payment">
    <div class="payment-text-block">
            <span>Pay by Bank Wire</span><br/>
        <span class="payment-description">Order Processing will be fastest</span>
    </div>
    <div class="payment-button-block">
        <button class="exclusive_large"
                onclick="location.href='{$link->getModuleLink('bankwire', 'payment',array(),true)}'">Confirm Payment
        </button>
    </div>
</div>
{*<p class="payment_module">*}
	{*<a href="{$link->getModuleLink('bankwire', 'payment')}" title="{l s='Pay by bank wire' mod='bankwire'}">*}
		{*<img src="{$this_path}bankwire.jpg" alt="{l s='Pay by bank wire' mod='bankwire'}" width="86" height="49"/>*}
		{*{l s='Pay by bank wire (order process will be longer)' mod='bankwire'}*}
	{*</a>*}
{*</p>*}
