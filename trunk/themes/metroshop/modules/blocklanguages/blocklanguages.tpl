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

<!-- Block languages module -->
                    <div class="form-language">
                       {if count($languages) > 1}
                        {foreach from=$languages key=k item=language name="languages"}
                         {assign var=indice_lang value=$language.id_lang} 
                               {if $language.iso_code == $lang_iso}
                        <div class="lang">{$language.name}  
                          <span class="separator {if $smarty.foreach.languages.first}first{elseif $smarty.foreach.languages.last}hidden{else}{/if}">|</span>
                        </div>
                    {else}
                        <div class="lang">
                            <a href="{$link->getLanguageLink($language.id_lang)|escape:htmlall}">{$language.name}</a>
                          <span class="separator {if $smarty.foreach.languages.first}first{elseif $smarty.foreach.languages.last}hidden{else}{/if}">|</span>
                        </div>
                    {/if}
                          {/foreach}
                      {/if}
                      <div style="clear: both;"></div>
                    </div>
                </div>
