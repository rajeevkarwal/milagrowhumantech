{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='Onemi'}</h2>

{assign var='current_step' value='payment'}

{if isset($nbProducts) && $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}

<h3>{l s='You have chosen to pay by Onemi Payment Gateway' mod='Onemi'}</h3>
<form name="checkout_confirmation" action="{$onemiurl}" method="post" />
	<input type="hidden" name="MerchantId" value="{$MerchantId}" />
	<input type="hidden" name="MerchantPass" value="{$MerchantPass}" />
	<input type="hidden" name="MerOrdRefNo" value="{$MerOrdRefNo}" />
	<input name="TranCur" type="hidden" value="{$TranCur}" />
	<input name="Amt" type="hidden" value="{$total}" />
	<input name="Cname" type="hidden" value="{$Cname}" />
	<input name="EmailId" type="hidden" value="{$EmailId}" />
	<input name="Mobile" type="hidden" value="{$Mobile}" />
	<input name="ResponseUrl" type="hidden" size="60" value="{$ResponseUrl}" />
	<input name="MerTranId" type="hidden" size="60" value="{$MerTranId}" />
	<input name="PromoCode" type="hidden" size="60" value="{$PromoCode}" />
	<input name="udf1" type="hidden" size="60" value="{$udf1}" />
	<input name="udf2" type="hidden" size="60" value="{$udf2}" />
	<input name="udf3" type="hidden" size="60" value="{$udf3}" />
	<input name="udf4" type="hidden" size="60" value="{$udf4}" />
	<input name="udf5" type="hidden" size="60" value="{$udf5}" />
	<input name="Signature" type="hidden" size="100" value="{$Signature}" />
    <p>
		{l s='Here is a short summary of your order:' mod='onemi'}
	</p>
	<p style="margin-top:20px;">
		- {l s='The total amount of your order is' mod='onemi'}
			<span id="amount_{$currency->id}" class="price">{convertPriceWithCurrency price=$total currency=$currency}</span>
			{if $use_taxes == 1}
			{l s='(tax incl.)' mod='onemi'}
			{/if}
	</p>
	<p>
        {l s='You will be redirected to Onemi to complete your payment.' mod='onemi'}
        <br /><br />
        <b>{l s='Please confirm your order by clicking \'I confirm my order\'' mod='onemi'}.</b>
    </p>
	<p class="cart_navigation">
       <!-- <input type="submit" name="submit" value="{l s='I confirm my order' mod='checkout'}" class="exclusive_large" /> -->
        <button class="button button_large" onclick="document.checkout_confirmation.submit();"> <span   mod='checkout'>I confirm my order </span></button>
        <a href="{$link->getPageLink('order', true, NULL, "step=3")}" class="button_large">{l s='Other payment methods' mod='onemi'}</a>
 	</p>
 </form>
{/if}
