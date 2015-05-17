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
<script type="text/javascript" src="{$jsSource}"></script>
<style>
    .std label {
        display: inherit;
    }

    #mobileCode {
        width: 25px;
    }

    #mobile {
        width: 170px;
    }
</style>
{capture name=path}{l s='Bulk Purchase'}{/capture}
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
                    <h1>{l s='Bulk Purchase'}</h1>
                </div>
                <form id="b2b" action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" data-ajax="true"
                      class="cms-banner"
                      novalidate="">
                    <p class="cms-banner-img"><img src="/img/cms/cms-banners/bulk-orders.png"
                                                   alt="milagrow-bulk-purchase"></p>

                    <p>
                        For bulk enquiries please fill the following form and we will get back to you very soon.
                    </p>

                    <p>
                        You can only select one category and product at a time to receive prompt and specific responses.
                    </p>
                    <ul class="form-list">
                        <li>
                            <label for="name" class="required"><em>*</em>Name</label>

                            <div class="input-box">
                                <input type="text" id="name" name="name"/>
                            </div>
                        </li>
                        <li>
                            <label for="name" class="required"><em>*</em>Company Name</label>

                            <div class="input-box">
                                <input type="text" id="companyName" name="companyName"/>
                            </div>
                        </li>
                        <li>
                            <label for="email" class="required"><em>*</em>Email</label>

                            <div class="input-box">
                                <input type="email" id="email" name="email"/>
                            </div>
                        </li>
                        <li>
                            <label for="mobile" class="required"><em>*</em>Mobile</label>

                            <div class="input-box">
                                <input type="text" id="mobileCode" name="mobileCode" placeholder="+91"/>
                                <input type="text" id="mobile" name="mobile"/>
                            </div>
                        </li>
                        <li>
                            <label for="country" class="required"><em>*</em>Country</label>

                            <div class="input-box">
                                <select name="country" id="country">
                                    <option value="India" selected="selected">India</option>
                                    <option value="Outside India">Outside India</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label for="pincode" class="required"><em>*</em>Pin Code</label>

                            <div class="input-box">
                                <input type="text" name="pincode" id="pincode"/>
                            </div>
                        </li>
                        <li>
                            <label for="state" class="required"><em>*</em>State</label>

                            <div class="input-box" id="india">
                                <select name="stateselect" id="stateselect">
                                    <option value="">{l s='-- Choose State --'}</option>
                                    {foreach from=$states item=state}
                                        <option value="{$state.name}">{$state.name|escape:'htmlall':'UTF-8'}</option>
                                    {/foreach}
                                </select>
                                    <input type="text" id="statetext" name="statetext" style="display: none"/>
                            </div>

                        </li>
                        <li>
                            <label for="city" class="required"><em>*</em>City</label>

                            <div class="input-box">
                                <input type="text" id="city" name="city"/>
                            </div>
                        </li>

                        <li>
                            <label for="category" class="required"><em>*</em>Select Category</label>

                            <div class="input-box">
                                <select name="category" id="category">
                                    <option value="">Select Category</option>
                                    {foreach from=$categories key=myId item=i}
                                        <option value="{$i.id_category}">{$i.name}</option>
                                    {/foreach}
                                </select>
                                                <span
                                                        id="ajax-loader-category"
                                                        style="display: none"><img
                                                            src="{$this_path}ajax-loader.gif"
                                                            alt="{l s='ajax-loader' mod='b2b'}"/></span>
                            </div>
                        </li>
                        <li>
                            <label for="product">Select Product</label>

                            {*<div class="input-box">*}
                            {*<select name="product" id="product">*}
                            {*<option value="">Select Product</option>*}
                            {*</select>*}
                            {*</div>*}

                            <div class="input-box">
                                <input id="product" name="product" type="text"
                                       placeholder="Please enter the model name">
                            </div>
                        </li>
                        <li>
                            <label for="quantity" class="required"><em>*</em>Quantity</label>

                            <div class="input-box">
                                <select name="quantity" id="quantity">
                                    <option value="">Select Quantity</option>
                                    <option value="less than 50">10-20</option>
                                    <option value="51-100">51-100</option>
                                    <option value="101-500">101-500</option>
                                    <option value="501-1000">501-1000</option>
                                    <option value="More than 1000">More than 1000</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label for="comment">Comments</label>

                            <div class="input-box">
                                <textarea id="comment" name="comment" style="width:36%"
                                          placeholder="Please be specific"></textarea>
                            </div>
                        </li>
                        <input type="hidden" name="captchaName" value="{$captchaName}">
                        <input type="hidden" name="formName" value="b2b"/>
                        <li>
                            <label for="captch" class="required"><em>*</em>{l s='Are you a human'} {$captchaText}</label>

                            <div class="input-box">
                                <input type="text" name="captcha" id="captch"/>
                            </div>
                        </li>
                        <li>
                            <p class="required">*Required Fields</p>
                            <button type="submit" name="submit" class="button">
                                <span><span>Submit</span></span>
                            </button><span
                                    id="ajax-loader"
                                    style="display: none"><img
                                        src="{$this_path}ajax-loader.gif"
                                        alt="{l s='ajax-loader' mod='b2b'}"/></span>

                        </li>
                    </ul>

                </form>

            </div>
        </div>
    </div>
</div>

