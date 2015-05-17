<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/themes/base/jquery-ui.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$jsSource}warranty.js"></script>

{capture name=path}{l s='Product Warranty Registration'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<div class="main">
    <style>
        #date {
            background: white;
            cursor: auto;
        }
    </style>
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
                    <h1>{l s='Product Warranty Registration'}</h1>
                </div>
                <form id="warranty" action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std"
                      data-ajax="true"
                      novalidate="">
                    <fieldset>
                        <p class="cms-banner-img"><img src="/img/cms/cms-banners/warranty-registration.png"
                                                       alt="milagrow-product-in-warranty-section"></p>

                        <p><strong>Online registration of product helps you with enhanced
                                technical support and faster warranty claims. It also helps you get notified of system
                                updates and new promotions from Milagrow HumanTech.</strong></p>
                        <ul class="form-list">
                            <li>

                                <label for="name" class="required"><em>*</em>Name</label>

                                <div class="input-box">
                                    <input type="text" id="name" name="name"/>
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
                                    <input type="text" id="mobile" name="mobile"/>
                                </div>
                            </li>
                            <li>
                                <label for="product" class="required"><em>*</em>Select Product</label>

                                <div class="input-box">
                                    <select name="product" id="product">
                                        <option value="">Select Product</option>
                                        {foreach from=$products key=myId item=i}
                                            <option value="{$i.id}">{$i.name}</option>
                                        {/foreach}
                                        <option value='-1'>Other</option>
                                    </select>
                                </div>
                            </li>

                            <li>
                                <label for="productNumber" class="required"><em>*</em>Product Number</label>

                                <div class="input-box">
                                    <input type="text" id="productNumber" name="productNumber"/>
                                </div>
                            </li>

                            <li>
                                <label for="date" class="required"><em>*</em>Date of Purchase</label>

                                <div class="input-box">
                                    <input type="text" id="date" name="date" readonly/>
                                </div>
                            </li>
                            <li>
                                <label for="storeName" class="required"><em>*</em>Store Name</label>

                                <div class="input-box">
                                    <input type="text" id="storeName" name="storeName"/>
                                </div>
                            </li>
                            <li>
                                <label for="address1">Address</label>

                                <div class="input-box">
                                    <textarea name="address" id="address" style="width:36%"></textarea>
                                </div>
                            </li>

                            <li>
                                <label>State</label>

                                <div class="input-box">
                                    <select name="state" id="state" style="width:230px;">
                                        <option value="">{l s='-- Choose State --'}</option>
                                        {foreach from=$states item=state}
                                            <option value="{$state.name}"
                                                    >{$state.name|escape:'htmlall':'UTF-8'}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </li>

                            <li>
                                <label>City</label>

                                <div class="input-box">
                                    <input type="text" id="city" name="city"/>
                                </div>
                            </li>

                            <li class="text">
                                <label class="required" for="Captcha"><strong>{l s='Are you a human'}</strong> <strong>{$captchaText}
                                        <em>*</em></strong></label>

                                <div class="input-box">
                                    <input type="text" name="captcha" id="captch"/>
                                </div>

                            </li>
                            <input type="hidden" name="captchaName" value="{$captchaName}">
                            <li>
                                <p class="required">*Required Fields</p>
                                <button id="warrantyButton" type="button" name="submit" class="button">
                                    <span><span>Submit</span></span>
                                </button><span id="ajax-loader" style="display: none"><img
                                            src="{$this_path}loader.gif" alt="{l s='loader' mod='warranty'}"/></span>

                            </li>
                        </ul>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>
