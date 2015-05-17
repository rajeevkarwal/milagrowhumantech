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

<div align="center">
    {if $logo_path}
        <img src="{$logo_path}" style="width:{$width_logo}px; height:{$height_logo}px;"/>
    {/if}
    <h3>Retail Invoice</h3>
</div>

    {*<tr>*}
    {*<td style="width: 50%;text-align: left;border-left: 1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;">*}

    {*<tr>*}
    {*<td style="font-size: 20px;">*}

    {*Milagrow Business & Knowledge Solutions (P) Ltd.<br>*}
    {*796,<br>*}
    {*Phase V,<br>*}
    {*Udyog Vihar<br>*}
    {*Gurgaon<br>*}
    {*Email: vijendra.jain@milagrow.in*}

    {*</td>*}
    {*</tr>*}


    {*</td>*}
    {*<td style="width: 50%; border-left: 1px solid #333;border-top: 1px solid #333;border-bottom: 1px solid #333;border-right: 1px solid #333;">*}

    {*<tr>*}
    {*<td style="border-right: 1px solid #333;border-bottom: 1px solid #333;text-align: center" rowspan="2"><strong>Invoice*}
    {*No.:</strong> {$title|escape:'htmlall':'UTF-8'}</td>*}
    {*<td style="border-right: 1px solid #333;border-bottom: 1px solid #333;text-align: center" rowspan="2"><strong>Dated:</strong> {$date|escape:'htmlall':'UTF-8'}*}
    {*</td>*}
    {*</tr>*}
    {*<tr>*}
    {*<td style="font-size: 18px; border-right: 1px solid #333;border-bottom: 1px solid #333;text-align: center">{$title|escape:'htmlall':'UTF-8'}</td>*}
    {*<td style="font-size: 18px; border-right: 1px solid #333;border-bottom: 1px solid #333;text-align: center">{$date|escape:'htmlall':'UTF-8'}</td>*}
    {*</tr>*}

    {*</td>*}
    {*</tr>*}
</table>


