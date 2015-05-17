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
{*<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/themes/base/jquery-ui.css" />*}
{*<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/jquery-ui.min.js"></script>*}
{*<script type="text/javascript" src="{$jsSource}partners.js"></script>*}
<style>
    .std label {
        display: inherit;
    }
    #dob {
        background: white;
        cursor: auto;
    }
    label {
        color: #666 ;
    }
    .required-asterisk{
        color: #eb340a;
    }
</style>
{capture name=path}{l s='Partners'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
            {if $themesdev.td_siderbar_without=="enable"}
                <div class="col-left sidebar span3">
                    {$HOOK_LEFT_COLUMN}
                    {$themesdev.td_left_sidebar_customhtml|html_entity_decode}

                </div>
            {/if}

            <div class="span9">
                <div class="page-title">
                    <h1>{l s='Partner With Us'}</h1>
                </div>


                    <form action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std"
                          enctype="multipart/form-data">

                        <fieldset>
                            <p class="cms-banner-img"><img src="/img/cms/cms-banners/partners-with-us.png" alt="partners-with-us-section"></p>
                            {if isset($confirmation)}
                            <p>{l s='Thank you for writing to us. Our team will soon get in touch with you.'}</p>
                            <ul class="footer_links">
                                <li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.gif"/></a><a
                                            href="{$base_dir}">{l s='Home'}</a></li>
                            </ul>
                            {else}
                            {include file="$tpl_dir./errors.tpl"}
                            <p>Option 1: For any queries, complaints, suggestions you can call on 9910069920 or 0124-4309577.
                                Timings: 10:00 AM – 7:00 PM.</p>
                            <p>Option 2: Also feel free to write to <a href="mailto:sales@milagrow.in">sales@milagrow.in</a></p>
                            <p>For international representation please write to <a href="mailto:exports@milagrow.in">exports@milagrow.in</a></p>
                            <p>You can also fill the form below and we will get back to you.</p>
                            <p class="text">
                                <label for="name"><strong>Name Of Company<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="name" name="name"
                                       value="{if isset($name)}{$name|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="email"><strong>Email address<span class="required-asterisk">*</span></strong></label>
                                {if isset($customerThread.email)}
                                    <input type="text" id="email" name="from"
                                           value="{$customerThread.email|escape:'htmlall':'UTF-8'}"
                                           readonly="readonly"/>
                                {else}
                                    <input type="text" id="email" name="from"
                                           value="{$email|escape:'htmlall':'UTF-8'}"/>
                                {/if}
                            </p>

                            <p class="text">
                                <label for="phone"><strong>Contact Number<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="phone" name="phone"
                                       value="{if isset($phone)}{$phone|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text select">
                                <label for="purpose"><strong>Purpose<span class="required-asterisk">*</span></strong></label>
                                <select name="purpose" id="purpose">
                                    <option value="" {if $purpose eq ''}selected="selected"{/if}>{l s='-- Choose purpose --'}</option>
                                    <option value="Commission Agent" {if $purpose eq 'Commission Agent'}selected="selected"{/if}>{l s='Commission Agent'}</option>
                                    <option value="Distributor" {if $purpose eq 'Distributor'}selected="selected"{/if}>{l s='Distributor'}</option>
                                    <option value="Etailer" {if $purpose eq 'Etailer'}selected="selected"{/if}>{l s='Etailer'}</option>
                                    <option value="Institutional Dealer" {if $purpose eq 'Institutional Dealer'}selected="selected"{/if}>{l s='Institutional Dealer'}</option>
                                    <option value="Multi Brand Retailer" {if $purpose eq 'Multi Brand Retailer'}selected="selected"{/if}>{l s='Multi Brand Retailer'}</option>
                                    <option value="Milagrow Robot Shop" {if $purpose eq 'Milagrow Robot Shop'}selected="selected"{/if}>{l s='Milagrow Robot Shop'}</option>
                                    <option value="Service Center" {if $purpose eq 'Service Center'}selected="selected"{/if}>{l s='Service Center'}</option>
                                    <option value="Others" {if $purpose eq 'Others'}selected="selected"{/if}>{l s='Others (Pls specify in Message Block)'}</option>
                                </select>
                            </p>

                            <p class="text select">
                                <label for="product"><strong>Product<span class="required-asterisk">*</span></strong></label>
                                <select name="product" id="product">
                                    <option value="" {if $product eq ''}selected="selected"{/if}>{l s='-- Choose Product --'}</option>
                                    <option value="TabTops" {if $product eq 'TabTops'}selected="selected"{/if}>{l s='Tab Tops'}</option>
                                    <option value="Floor Robots" {if $product eq 'Floor Robots'}selected="selected"{/if}>{l s='Floor Robots'}</option>
                                    <option value="Window Robots" {if $product eq 'Window Robots'}selected="selected"{/if}>{l s='Window Robots'}</option>
                                    <option value="Pool Robots" {if $product eq 'Pool Robots'}selected="selected"{/if}>{l s='Pool Robots'}</option>
                                    <option value="Lawn Robots" {if $product eq 'Lawn Robots'}selected="selected"{/if}>{l s='Lawn Robots'}</option>
                                    {*<option value="Health & Educational Robots" {if $product eq 'Health & Educational Robots'}selected="selected"{/if}>{l s='Health & Educational Robots'}</option>*}
                                    <option value="Air Purifiers" {if $product eq 'Air Purifiers'}selected="selected"{/if}>{l s='Air Purifiers'}</option>
                                    <option value="TV Mounts" {if $product eq 'TV Mounts'}selected="selected"{/if}>{l s='TV Mounts'}</option>
                                    <option value="All" {if $product eq 'All'}selected="selected"{/if}>{l s='ALL'}</option>
                                </select>

                            </p>

                            <p class="text select">
                                <label for="state"><strong>State & UT.<span class="required-asterisk">*</span></strong></label>
                                <select name="state" id="state">
                                    <option value="">{l s='-- Choose State --'}</option>
                                    {foreach from=$states item=state}
                                        <option value="{$state.name}" {if $stateselected eq $state.name}selected="selected"{/if}>{$state.name|escape:'htmlall':'UTF-8'}</option>
                                    {/foreach}
                                </select>
                            </p>




                            <p class="text">
                                <label for="city"><strong>City<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="city" name="city"
                                       value="{if isset($city)}{$city|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="textarea">
                                <label for="address"><strong>Address<span class="required-asterisk">*</span></strong></label>
                                <textarea id="address" name="address" rows="3"
                                          cols="50">{if isset($address)}{$address|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                            </p>

                            <p class="text">
                                <label for="website"><strong>Your Website</strong></label>
                                <input type="text" id="website" name="website"
                                       value="{if isset($website)}{$website|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="turnover"><strong>Current Turnover</strong></label>
                                <input type="text" id="turnover" name="turnover"
                                       value="{if isset($turnover)}{$turnover|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="textarea">
                                <label for="message"><strong>Message</strong></label>
                                <textarea id="message" name="message" rows="5" placeholder="Please mention your current products, brands, territory handled, territory desired and organization etc"
                                          cols="50">{if isset($message)}{$message|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                            </p>

                            <p class="text">
                                <label for="Captcha"><strong>Are you a human {$captchaText}<span class="required-asterisk">*</span></strong></label>

                                <input type="text" name="captcha" id="captch"/>
                            </p>
                            <input type="hidden" name="captchaName" value="{$captchaName}">

                            <p class="submit">
                                <button type="submit" name="submitMessage" id="submitMessage" class="button" onclick="$(this).hide();" >
                                    <span><span>{l s='Send'}</span></span>
                                </button>
                            </p>
                        </fieldset>
                    </form>
                {/if}
            </div>
        </div>
    </div>
</div>

