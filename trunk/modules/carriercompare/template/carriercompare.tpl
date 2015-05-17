{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 9095 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
**}

{if !$opc}
    <script type="text/javascript">
    // <![CDATA[
    var taxEnabled = "{$use_taxes}";
    var displayPrice = "{$priceDisplay}";
    var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
    var currencyRate = '{$currencyRate|floatval}';
    var currencyFormat = '{$currencyFormat|intval}';
    var currencyBlank = '{$currencyBlank|intval}';
    var id_carrier = '{$id_carrier|intval}';
    var id_state = '{$id_state|intval}';
    var SE_RedirectTS = "{l s='Refreshing page and updating cart...' mod='carriercompare'}";
    var SE_RefreshStateTS = "{l s='Checking available states...' mod='carriercompare'}";
    var SE_RetrievingInfoTS = "{l s='Retrieving information...' mod='carriercompare'}";
    var SE_RefreshMethod = {$refresh_method};

    var txtFree = "{l s='Free!' mod='carriercompare'}";
	
    PS_SE_HandleEvent();
    //]]>
    </script>



    <div class="shipping">
        <h2>{l s='Estimate Shipping and Tax' mod='carriercompare'}</h2>
        <div class="shipping-form">
            <form  id="compare_shipping_form" method="post" action="#" >
                <p>{l s='Estimate your shipping & taxes' mod='carriercompare'}</p>
                <p id="carriercompare_errors" style="display: none;">
                <ul id="carriercompare_errors_list">

                </ul>
                </p>
                <ul class="form-list">
                    <li>
                        <label class="required" for="country"><em>*</em>{l s='Country' mod='carriercompare'}</label>
                        <div class="input-box">
                            <label for="id_country"></label>
                            <select name="id_country" id="id_country">
                                {foreach from=$countries item=country}
                                    <option value="{$country.id_country}" {if $id_country == $country.id_country}selected="selected"{/if}>{$country.name|escape:'htmlall':'UTF-8'}</option>
                                {/foreach}
                            </select>        
                        </div>
                    </li>
                    <li id="states" style="display: none;">
                        <label for="region_id id_state">{l s='State/Province' mod='carriercompare'}</label>
                        <div class="input-box">
                            <select name="id_state" id="id_state">

                            </select>

                        </div>
                    </li>
                    <li>
                        <label for="postcode">{l s='Zip/Postal Code' mod='carriercompare'}</label>
                        <div class="input-box">

                            <input type="text" name="zipcode" class="input-text validate-postcode" id="zipcode" value="{$zipcode|escape:'htmlall':'UTF-8'}"/> 
                            ({l s='Needed for certain carriers' mod='carriercompare'})

                        </div>
                    </li>
                </ul>



                <div id="SE_AjaxDisplay">
                    <img src="{$new_base_dir}loader.gif" /><br />
                    <p></p>
                </div>

                <div id="availableCarriers" style="display: none;">
                    <table cellspacing="0" cellpadding="0" id="availableCarriers_table" class="std">
                        <thead>
                            <tr>
                                <th class="carrier_action first_item"></th>
                                <th class="carrier_name item">{l s='Carrier' mod='carriercompare'}</th>
                                <th class="carrier_infos item">{l s='Information' mod='carriercompare'}</th>
                                <th class="carrier_price last_item">{l s='Price' mod='carriercompare'}</th>
                            </tr>
                        </thead>
                        <tbody id="carriers_list">

                        </tbody>
                    </table>
                </div>
                <p class="warning center" id="noCarrier" style="display: none;">{l s='No carrier is available for this selection' mod='carriercompare'}</p>
                <div class="buttons-set">
                    <p class="SE_SubmitRefreshCard">
                        <button class="button left" id="carriercompare_submit" type="submit" name="carriercompare_submit" ><span><span>{l s='Update Cart' mod='carriercompare'}</span></span></button>
                        <button id="update_carriers_list" type="button" class="button"><span><span>{l s='Update carrier' mod='carriercompare'}</span></span></button>
                    </p>		
                </div>											

        </div>
    </form>


</div>


{/if}    

