<div id="LoginPopup">
    <form method="post" id="LoginPopupForm" class="std" action="{$link->getPageLink('authentication', true)}">
        <fieldset>
            <h3 id="LoginPopupTitle">Login</h3>

            <div id="LoginPopupError">
            </div>
            <p class="text">
                <label for="email">E-mail</label>
                <input type="text" id="LoginPopupEmail" name="email" value="" class="text">
            </p>

            <p class="text">
                <label for="passwd">Password</label>
                <input type="password" id="LoginPopupPasswd" name="passwd" value="" class="text">
            </p>

            {*<p class="text1">*}
            {*<label>&nbsp;</label>*}

            {*</p>*}
            <p class="submit">
                <input type="button" id="SubmitLoginPopup" name="SubmitLoginPopup" class="button submit_login_button"
                       onclick="submitLogin()" value="LOGIN"> <span class="text"><a href="/password-recovery">Forgot your
                        password?</a></span>
            </p>

            <p class="account-register-block">
            <span class="new-account-text">Don't have an account? <a href="/my-account">Create One!</a></span>
            </p>
        </fieldset>
    </form>
    
 
    
</div>

<div id="RegisterPopup">

<!--<form action="{$link->getPageLink('authentication', true)}" method="post" id="account-creation_form" class="std">
    {$HOOK_CREATE_ACCOUNT_TOP}
    <fieldset class="account_creation">
        <h3>{l s='Your personal information'}</h3>

        <p class="radio">
            <span>{l s='Title'}</span>
            {foreach from=$genders key=k item=gender}
                <input type="radio" name="id_gender" id="id_gender{$gender->id}" value="{$gender->id}"
                       {if isset($smarty.post.id_gender) && $smarty.post.id_gender == $gender->id}checked="checked"{/if} />
                <label for="id_gender{$gender->id}" class="top">{$gender->name}</label>
            {/foreach}
        </p>

        <p class="required text">
            <label for="customer_firstname">{l s='First name'} <sup>*</sup></label>
            <input onkeyup="$('#firstname').val(this.value);" type="text" class="text" id="customer_firstname"
                   name="customer_firstname"
                   value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}"/>
        </p>

        <p class="required text">
            <label for="customer_lastname">{l s='Last name'} <sup>*</sup></label>
            <input onkeyup="$('#lastname').val(this.value);" type="text" class="text" id="customer_lastname"
                   name="customer_lastname"
                   value="{if isset($smarty.post.customer_lastname)}{$smarty.post.customer_lastname}{/if}"/>
        </p>

        <p class="required text">
            <label for="email">{l s='E-mail'} <sup>*</sup></label>
            <input type="text" class="text" id="email" name="email"
                   value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}"/>
        </p>

        <p class="required password">
            <label for="passwd">{l s='Password'} <sup>*</sup></label>
            <input type="password" class="text" name="passwd" id="passwd"/>
            <span class="form_info">{l s='(5 characters min.)'}</span>
        </p>

        <p class="select">
            <span>{l s='Date of Birth'}</span>
            <select id="days" name="days">
                <option value="">-</option>
                {foreach from=$days item=day}
                    <option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
                {/foreach}
            </select>
            {*
            {l s='January'}
            {l s='February'}
            {l s='March'}
            {l s='April'}
            {l s='May'}
            {l s='June'}
            {l s='July'}
            {l s='August'}
            {l s='September'}
            {l s='October'}
            {l s='November'}
            {l s='December'}
            *}
            <select id="months" name="months">
                <option value="">-</option>
                {foreach from=$months key=k item=month}
                    <option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month}&nbsp;</option>
                {/foreach}
            </select>
            <select id="years" name="years">
                <option value="">-</option>
                {foreach from=$years item=year}
                    <option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}
                        &nbsp;&nbsp;</option>
                {/foreach}
            </select>
        </p>
        {if $newsletter}
            <p class="checkbox">
                <input type="checkbox" name="newsletter" id="newsletter"
                       value="1" {if isset($smarty.post.newsletter) AND $smarty.post.newsletter == 1} checked="checked"{/if} />
                <label for="newsletter">{l s='Sign up for our newsletter'}</label>
            </p>
            <p class="checkbox">
                <input type="checkbox" name="optin" id="optin"
                       value="1" {if isset($smarty.post.optin) AND $smarty.post.optin == 1} checked="checked"{/if} />
                <label for="optin">{l s='Receive special offers from our partners'}</label>
            </p>
        {/if}
    </fieldset>
   
    
    {$HOOK_CREATE_ACCOUNT_FORM}
    <fieldset>
    <p class="cart_navigation required submit">
        <input type="hidden" name="email_create" value="1"/>
        <input type="hidden" name="is_new_customer" value="1"/>
        {if isset($back)}<input type="hidden" class="hidden" name="back"
                                value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
        <button type="submit" name="submitAccount" id="submitAccount" class="button btn_button float-right">
            <span><span>{l s='Register'}</span></spna></button>
        <span><sup>*</sup>{l s='Required field'}</span>
    </p>
    </fieldset>
    </form>-->
    
  <form name="formname" method="post" action="{$link->getPageLink('authentication', true)}" id="account-creation_form" >  

   
    <fieldset class="account_creation">
        <h3>{l s='Registeration Form'}</h3>
 <div id="RegisterPopupError">
            </div>
        <p class="radio">
         <span>Title</span> 
         <input type="radio" value="1" id="id_gender1" name="id_gender"> <label for="id_gender1" class="top">Mr.</label> 
         <input type="radio" value="2" id="id_gender2" name="id_gender"> <label for="id_gender2" class="top">Ms.</label>
          <input type="radio" value="3" id="id_gender3" name="id_gender"> <label for="id_gender3" class="top">Miss</label>
          
          </p>

        <p class="required text">
            <label for="customer_firstname">{l s='First name'} <sup>*</sup></label>
            <input type="text" value="" name="customer_firstname" id="RegisterPopupFirstname" class="text" >
        </p>

        <p class="required text">
            <label for="customer_lastname">{l s='Last name'} <sup>*</sup></label>
             <input type="text" value="" name="customer_lastname" id="RegisterPopupLasttname" class="text" >
            
        </p>

        <p class="required text">
            <label for="email">{l s='E-mail'} <sup>*</sup></label>
             <input type="text" id="RegisterPopupEmail" name="email" value="" class="text">
           
        </p>

        <p class="required password">
            <label for="passwd">{l s='Password'} <sup>*</sup></label>
            <input type="password" id="RegisterPopupPasswd" name="passwd" value="" class="text">
            <span class="form_info">{l s='(5 characters min.)'}</span>
        </p>

        
        
        
         <p class="cart_navigation required submit">
       
       
        <button type="submit" name="SubmitRegisterPopup" id="SubmitRegisterPopup" class="button btn_button float-right" onclick="submitRegister()">
            <span><span>{l s='Register'}</span></spna></button>
        <span><sup>*</sup>{l s='Required field'}</span>
    </p>
    </fieldset>
   
    
   
    
   
   
    </form>    


</div>



