<p>
<h1 class="products-block-header">{l s='News' mod='psmodnewsletter'}</h1>
<p class="products-block-subheader">{l s='Our latest news and announcements' mod='psmodnewsletter'}</p>
<div class="shop-news clearfix">
    <div class="newslettter-box">
         <form action="{$link->getPageLink('index')}" method="post" id="newsletter-validate-detail">
                     <div class="form-subscribe clearfix">
                        <div class="form-subscribe-header"><h4>{l s='Sign Up for Our Newsletter' mod='psmodnewsletter'}</h4></div>
                        {if isset($msg) && $msg}
                        <div style="" id="advice-required-entry-newsletter" class="validation-advice">
                            <p class="{if $nw_error}warning_newsletter{else}success_newsletter{/if}">{$msg}</p>
                        </div>
                    {/if} 
                        <div class="input-box">
                            <input type="text" name="email" size="18"  id="newsletter" 
                               value="{if isset($value) && $value}{$value}{else}{l s='Enter your email address...' mod='psmodnewsletter'}{/if}" 
                               onfocus="javascript:if(this.value=='{l s='Enter your email address...' mod='psmodnewsletter'}')this.value='';" 
                               onblur="javascript:if(this.value=='')this.value='{l s='Enter your email address...' mod='psmodnewsletter'}';" 
                               title="{l s='Sign up for our newsletter' mod='psmodnewsletter'}"  class="input-text required-entry validate-email"  />

                             <button type="submit"  rel="tooltip"  name="submitNewsletter" title="{l s='Subscribe' mod='psmodnewsletter'}" class="button"><span><span>{l s='Submit' mod='psmodnewsletter'}</span></span></button>
                       </div>  
                   
                    <input type="hidden" name="action" value="0" />  
                    </div>
      </form>        
    </div>
    