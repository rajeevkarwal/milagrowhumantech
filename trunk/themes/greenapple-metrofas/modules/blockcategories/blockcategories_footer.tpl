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

<div class="ma-footer-static-container">
    <div class="ma-footer-static container">
        <div class="ma-footer-static-inner">
            <div class="row-fluid show-grid">


                <div class="information span2">
                    <div class="footer-static-title">
                        <h3>{l s='Categories' mod='blockcategories'}</h3>
                    </div>
                    <div class="footer-static-content">
                        <ul class="tree {if $isDhtml}dhtml{/if}">

                            {foreach from=$blockCategTree.children item=child name=blockCategTree}
                                {if $smarty.foreach.blockCategTree.last}
                                    {include file="$branche_tpl_path" node=$child last='true'}
                                {else}
                                    {include file="$branche_tpl_path" node=$child}
                                {/if}

                                {if ($smarty.foreach.blockCategTree.iteration mod $numberColumn) == 0 AND !$smarty.foreach.blockCategTree.last}
                                </ul>


                                <ul class="tree {if $isDhtml}dhtml{/if}">
                                {/if}
                            {/foreach}
                        </ul>
                    </div>
                </div>





                <!-- Block categories module -->



                <!-- /Block categories module -->
