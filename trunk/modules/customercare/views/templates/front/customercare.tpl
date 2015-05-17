<script type="text/javascript" src="{$jsSource}customer_care.js"></script>
<style>
    .std label {
        display: inherit;
    }

    #dob {
        background: white;
        cursor: auto;
    }

    label {
        color: #666;
    }

    .required-asterisk {
        color: #eb340a;
    }
</style>
{capture name=path}{l s='Customer Care'}{/capture}
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
                    <h1>{l s='Customer Care'}</h1>
                </div>

                <form action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std" id="customerCare"
                      enctype="multipart/form-data">
                    <fieldset>
                        <p class="cms-banner-img"><img src="/img/cms/cms-banners/customer_care.png"
                                                       alt="milagrow-careers-section"></p>

                        {if isset($confirmation)}
                        <p>{l s='Thank you, We have received your enquiry.'}
                        </p>
                        {if isset($alertMessage)}
                            <p>{$alertMessage}</p>
                        {/if}

                        <ul class="footer_links">
                            <li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.gif"/></a>
                                <a href="{$base_dir}">{l s='Home'}</a>
                            </li>
                        </ul>
                        {else}
                        {include file="$tpl_dir./errors.tpl"}

                        <p class="text">
                            <label for="name"><strong>Name<span class="required-asterisk">*</span></strong> </label>
                            <input type="text" id="name" name="name"
                                   value="{if isset($name)}{$name|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                        </p>

                        <p class="text">
                            <label for="email"><strong>Email Address<span
                                            class="required-asterisk">*</span></strong></label>
                            <input type="text" id="email" name="email"
                                   value="{if isset($email)}{$email|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                        </p>

                        <p class="text">
                            <label for="phone"><strong>Phone Number <span
                                            class="required-asterisk">*</span></strong></label>
                            <input type="text" id="phone" name="phone"
                                   value="{if isset($phone)}{$phone|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
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
                            <input type="text" id="city" name="city" value="{if isset($city)}{$city|escape:'htmlall':'UTF-8'|stripslashes}{/if}" />
                        </p>

                        <p class="text select">

                            <select name="product" id="product">
                                <option value="" {if $product eq ''}selected="selected"{/if}>Select Product </option>
                                <option value="Accessories" {if $product eq 'Accessories'}selected="selected"{/if}>Accessories</option>
                                <option value="Robotic Body Massagers" {if $product eq 'Robotic Body Massagers'}selected="selected"{/if}>Body Robots</option>
                                <option value="Robotic Vacuum Cleaners" {if $product eq 'Robotic Vacuum Cleaners'}selected="selected"{/if}>Floor Robots</option>
                                <option value="Lawn Robots" {if $product eq 'Lawn Robots'}selected="selected"{/if}>Lawn Robots</option>
                                <option value="Pool Robots" {if $product eq 'Pool Robots'}selected="selected"{/if}>Pool Robots</option>
                                {*<option value="Lawn Robots" {if $product eq 'Lawn Robots'}selected="selected"{/if}>Lawn Robots</option>*}
                                 <option value="TabTops" {if $product eq 'TabTops'}selected="selected"{/if}>TabTops</option>
                                {*<option value="Air Purifiers" {if $product eq 'Air Purifiers'}selected="selected"{/if}>Air Purifiers</option>*}
                                {*<option value="Robotic Body Massagers" {if $product eq 'Robotic Body Massagers'}selected="selected"{/if}>Body Robots</option>*}
                                <option value="TV Mounts and Racks" {if $product eq 'TV Mounts and Racks'}selected="selected"{/if}>TV Mounts</option>
                                <option value="Robotic Window Cleaners" {if $product eq 'Robotic Window Cleaners'}selected="selected"{/if}>Window Robots</option>
                                {*<option value="Air Purifiers" {if $product eq 'Air Purifiers'}selected="selected"{/if}>Air Purifiers</option>*}
                            </select>

                        </p>
                        <p>
                            <label><strong>Are you an existing customer<span class="required-asterisk">*</span></strong>
                            </label>
                                <span>
                                <input type="radio" class="existingCustomer" name="existingCustomer" value="yes" {if $existingcustomerselected eq 'yes'} checked="checked"{/if}>
                                    Yes
                                </span>
                                <span style="margin-left: 10px;">
                                <input type="radio" class="existingCustomer" name="existingCustomer" value="no" {if $existingcustomerselected eq 'no'} checked="checked"{/if}>
                                    No
                                </span>
                        </p>

                        <p class="text select">
                            <input type="hidden" name="purpose" id="purpose" value="{if isset($purpose)}{$purpose|escape:'htmlall':'UTF-8'|stripslashes}{/if}" >
                            <select name="category" id="category">
                                <option value="" selected="selected">Select Purpose</option>
                            </select>

                        </p>
                        <p class="textarea">
                            <label for="message"><strong>Remarks<span class="required-asterisk">*</span></strong></label>
                            <textarea id="message" name="message" rows="5" cols="50"
                            placeholder="Please enter your Order Number, Product Name and Date of purchase in case you are an existing customer.">{if isset($message)}{$message|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                        </p>

                        <p class="text">
                            <label for="fileUpload">{l s='Attach Image/Bill of product (jpeg,png,jpg,pdf,doc,docx,rtf)'}</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                            <input type="file" name="fileUpload" id="fileUpload"/>
                        </p>

                        <p class="text">
                            <label for="Captcha"><strong>{l s='Are you a human'} {$captchaText}<span
                                            class="required-asterisk">*</span></strong></label>

                            <input type="text" name="captcha" id="captch"/>
                        </p>
                        <input type="hidden" name="captchaName" value="{$captchaName}">

                        <p class="submit">
                            <button type="submit" name="submitMessage" id="submitMessage" class="button"
                                    ><span><span>{l s='Send'}</span></span></button>
                        </p>
                    </fieldset>
                </form>
                {/if}
            </div>
        </div>
    </div>
</div>

