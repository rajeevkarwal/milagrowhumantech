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
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/themes/base/jquery-ui.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$jsSource}careers.js"></script>
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
{capture name=path}{l s='Careers'}{/capture}
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
                    <h1>{l s="Careers"}</h1>
                </div>

                    <form action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post"
                          enctype="multipart/form-data" class="std">
                        <fieldset>
                            <p class="cms-banner-img"><img src="/img/cms/cms-banners/career.png" alt="milagrow-careers-section"></p>
                            {if isset($confirmation)}
                            <p>{l s='Thank you for considering milagrow as your employer of choice. Our HR department will get back you, In case we have an open vacancy suiting your profile and qualification we will get back to you. If we do not have an open vacancy currently your bio data would go
                        into our manpower bank and we will get back to you at an appropriate time.'}</p>
                            <ul class="footer_links">
                                <li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.gif"/></a><a
                                            href="{$base_dir}">{l s='Home'}</a></li>
                            </ul>
                            {else}
                            {include file="$tpl_dir./errors.tpl"}
                            <p class="text"><strong>
                                Milagrow is always in search for good people, for its various departments and functions. Kindly
                                fill in the form below and if we have an open vacancy matching your experience and qualifications we
                                will get back to you. If we do not have an open vacancy currently, your bio data would go
                                into our manpower bank and we will get back to you at an appropriate time.</strong></p>
                            <br/>
                            <p class="text">
                                <strong>Current vacancies exist at various levels in the following functions</strong>
                            </p>
                            <ol type="1">
                            <li>1. <b>Institutional Sales</b> - Health Care Industry, Sales Automation, Educational Industry, Real Estate Industry, Hospitality Industry for Andhra. Delhi,  Gujarat, Kerala, Maharashtra, Punjab, Rajasthan UP, WB </li>
                            <li>2. <b>Channel Sales</b> - Delhi, UP, Maharashtra, Karnataka, Tamil Nadu, Kerala, Andhra.</li>
                            <li>3. <b>3rd party Ecommerce Sales</b> - Gurgaon</li>
                            <li>4. <b>Social Media and Digital Marketing </b> - Gurgaon</li>
                            <li>5. <b>After Sales Service</b> - Robotics Engineers for locations across India.</li>
                            <li>6. <b>HRD</b> - Gurgaon</li>
                            <li>7. <b>R&D</b> - Robotics Engineers - Gurgaon</li>
                            </ol>
                            <br/>
                            <p class="text">
                                <label for="name"><strong>Name<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="name" name="name"
                                       value="{if isset($name)}{$name|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="dob"><strong>Date Of Birth<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="dob" name="dob"
                                       readonly
                                       value="{if isset($dob)}{$dob|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
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
                                <label for="address"><strong>Address</strong></label>
                                <textarea id="address" name="address" rows="5"
                                          cols="50">{if isset($address)}{$address|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                            </p>



                            <p class="text">
                                <label for="phone"><strong>Phone<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="phone" name="phone"
                                       value="{if isset($phone)}{$phone|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="email"><strong>Email Address<span class="required-asterisk">*</span></strong></label>
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
                                <label for="phone"><strong>Post Applied For<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="postappliedfor" name="postappliedfor"
                                       value="{if isset($postappliedfor)}{$postappliedfor|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text select">
                                <label for="department"><strong>Department<span class="required-asterisk">*</span></strong></label>
                                <select name="department" id="department">
                                    <option value=""
                                            {if $department eq ''}selected="selected"{/if}>{l s='Select Department'}</option>
                                    <option value="Marketing & Sales"
                                            {if $department eq 'Marketing & Sales'}selected="selected"{/if}>{l s='Marketing & Sales'}</option>
                                    <option value="HR/Admin"
                                            {if $department eq 'HR/Admin'}selected="selected"{/if}>{l s='HR/Admin'}</option>
                                    <option value="Finance/Accounts"
                                            {if $department eq 'Finance/Accounts'}selected="selected"{/if}>{l s='Finance/Accounts'}</option>
                                    <option value="After Sales"
                                            {if $department eq 'After Sales'}selected="selected"{/if}>{l s='After Sales'}</option>
                                    <option value="Technical Service"
                                            {if $department eq 'Technical Service'}selected="selected"{/if}>{l s='Technical Service'}</option>
                                    <option value="Others"
                                            {if $department eq 'Others'}selected="selected"{/if}>{l s='Others'}</option>

                                </select>

                            </p>
                            <p class="text">
                                <label for="education"><strong>Education Qualification<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="education" name="education"
                                       value="{if isset($education)}{$education|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="professional"><strong>Professional Qualification<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="professional" name="professional"
                                       value="{if isset($professional)}{$professional|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="skill"><strong>Primary Skill</strong></label>
                                <input type="text" id="skill" name="primarySkill"
                                       value="{if isset($primarySkill)}{$primarySkill|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>


                            <p class="textarea">
                                <label for="careerhighlights"><strong>Career Highlights<span class="required-asterisk">*</span></strong></label>
                                <textarea id="careerhighlights" name="careerhighlights" rows="5"
                                          cols="50">{if isset($careerhighlights)}{$careerhighlights|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                            </p>

                            <p class="text">
                                <label for="work"><strong>Work Experience</strong></label>
                                <input type="text" id="work" name="workExperience"
                                       value="{if isset($workExperience)}{$workExperience|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="fileUpload"><strong>Attach Resume<span class="required-asterisk">*</span></strong> (pdf, doc, docx, rtf)</label><br>
                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                                <input type="file" name="fileUpload" id="fileUpload"/>
                            </p>
                            <input type="hidden" name="captchaName" value="{$captchaName}">
                            <p class="text">
                                <label for="Captcha"><strong>Are you a human {$captchaText}<span class="required-asterisk">*</span></strong></label>

                                <input type="text" name="captcha" id="captch"/>
                            </p>
                            <p class="submit">
                                <button type="submit" name="submitMessage" id="submitMessage" class="button"
                                        onclick="$(this).hide();"><span><span>{l s='Send'}</span></span></button>
                            </p>
                        </fieldset>
                    </form>
                {/if}
            </div>
        </div>
    </div>
</div>

