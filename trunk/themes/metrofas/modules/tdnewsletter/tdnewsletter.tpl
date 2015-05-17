              
<div class="span3 fcol2">
    <div class="footer-static-title">
        <h3>{l s='Newsletter' mod='tdnewsletter'}</h3>
    </div>
    <div class="footer-static-content">
        <div class="footer-subscribe">
            <form action="{$link->getPageLink('index')}"  method="post">
                <div class="subscribe-content">
                    <div class="form-subscribe-header">
                        <h4>{l s='Sign up for Newsletter' mod='tdnewsletter'}</h4>
                        <label for="newsletter">{l s='Your email address' mod='tdnewsletter'}</label>
                    </div>
                    <div class="input-box">
                        <div class="input-box-inner">
                            <input class="input-medium input-text required-entry validate-email" id="newsletter"  type="text" name="email" placeholder="{l s='Email address' mod='tdnewsletter'}">
                        </div>
                    </div>
                    <div class="actions">
                        <button class="button"  rel="tooltip"  name="submitNewsletter"><span><span>{l s='Submit' mod='tdnewsletter'}</span></span></button>
                        <input type="hidden" name="action" value="0" />
                    </div>
                    {if isset($msg) && $msg}
                        <p class="{if $nw_error}warning_inline{else}success_inline{/if}">{$msg}</p>
                    {/if}
                </div>
            </form>
        </div>

    </div>
</div>                     