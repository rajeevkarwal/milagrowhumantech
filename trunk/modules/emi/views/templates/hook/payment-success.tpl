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

<div class="payment-main-block" style="display: none;" id="city_payment">
    <div class="payment-text-block">
        <span>Citibank EMI (only applicable for Citibank credit card(Master/Visa Card)holders)
            {*<span style="color: #d32618; font-weight: bold;">Other EMI options are given in the above option</span>*}
         </span><br>
        <span  class="payment-description">Extra 12% per annum will be charged by citibank as interest.</span>
    </div>
    <div class="payment-button-block">
        <button class="exclusive_large" onclick="location.href='{$link->getModuleLink('emi', 'validation', [], true)}'">Confirm Payment</button>
    </div>
</div>
