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
<script type="text/javascript" src="{$jsSource}seniordiscount.js"></script>
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
{capture name=path}{l s='Senior Citizen Discount'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<script>
var pamt = {$prodamt};
function  getamt(){
var prod_id = document.getElementById('product');
var Pid = prod_id.options[prod_id.selectedIndex].value;
var prodamt =   pamt[Pid]; 
$('#cost').val(prodamt);
}

</script>

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
                    <h1>{l s='Special discount for Senior Citizens and Defence Personals'}</h1>
                </div>

                    {include file="$tpl_dir./errors.tpl"}
                    <form action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std"
                          id="seniorCitizenDiscountForm"
                          enctype="multipart/form-data">
                        <fieldset>

                            <p class="cms-banner-img"><img src="/img/cms/cms-banners/senior-citizen.png"
                                                           alt="milagrow senior citizen section"></p>
                            {if isset($confirmation)}
                            <p>{l s='Thank you for applying to us. Our team will soon get in touch with you.'}</p>
                            <ul class="footer_links">
                                <li><a href="{$base_dir}"><img class="icon" alt="" src="{$img_dir}icon/home.gif"/></a><a
                                            href="{$base_dir}">{l s='Home'}</a></li>
                            </ul>
                            {else}
                            <h5>Discount is only available to Indian Senior Citizens and Defence Personals</h5>
                          				 
                                       
									
                            <p class="text">
                                <label for="name"><strong>Name</strong><span class="required-asterisk">*</span></label>
                                <input type="text" id="name" name="name"
                                       value="{if isset($name)}{$name|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text select">
                                <label for="interest"><strong>Interested In<span
                                                class="required-asterisk">*</span></strong></label>
                                {$products}
                            </p>

                             <p class="text">
                                     <label for="cost"> <strong>Discount<span class="required-asterisk">*</span></strong></label>
                                     <input type="text" id="cost" name="cost" readonly/>
                            </p>
                            <p class="text">
                                <label for="city"><strong>City<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="city" name="city"
                                       value="{if isset($city)}{$city|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                               <label for="mobile"><strong>Mobile<span
                                                class="required-asterisk">*</span></strong></label>
                                <input type="text" id="mobile" name="mobile"
                                       value="{if isset($mobile)}{$mobile|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="dob"><strong>Date Of Birth<span class="required-asterisk">*</span></strong></label>
                                <input type="text" id="dob" name="dob"
                                       readonly
                                       value="{if isset($dob)}{$dob|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </p>

                            <p class="text">
                                <label for="email"><strong>Email address<span
                                                class="required-asterisk">*</span></strong></label>
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
                                <label for="fileUpload"><strong>Attach ID Proof<span class="required-asterisk">*</span></strong>
                                    (jpeg,png,jpg,pdf,doc,docx,rtf)</label>
                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                                <input type="file" name="fileUpload" id="fileUpload"/>
                            </p>

                            <p class="text">
                                <label for="Captcha"><strong>Are you a human {$captchaText}<span
                                                class="required-asterisk">*</span></strong></label>

                                <input type="text" name="captcha" id="captch"/>
                            </p>
                            <input type="hidden" name="captchaName" value="{$captchaName}">
                            <p class="submit">
                                <button type="submit" name="submitMessage" id="submitMessage" class="button"
                                        ><span><span>{l s='Send'}</span></span></button>
                            </p>
                        </fieldset>

                {/if}
                    </form>
            </div>
        </div>
    </div>
</div>

                                
								
                            
