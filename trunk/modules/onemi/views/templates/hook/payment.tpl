<!--p class="payment_module">
	<a href="{$link->getModuleLink('onemi', 'payment', [], true)}" title="{l s='Pay by Onemi' mod='onemi'}">
		<img src="{$this_path}logo.png" alt="{l s='Pay by Onemi' mod='onemi'}" />
		{l s='Pay with Onemi Payment Gateway' mod='onemi'}
	</a>
</p-->

<div class="payment-main-block" style="display: none;" id="onemi_payment">
    <div class="payment-text-block">
        <span>Pay using ONEMI</span>
    </div>
    <div class="payment-button-block">
    	<button class="exclusive_large" onclick="location.href='{$link->getModuleLink('onemi', 'payment', [], true)}'">Confirm Payment </button>

       <!--  <a href="{$link->getModuleLink('onemi', 'payment', [], true)}" title="{l s='Pay by Onemi' mod='onemi'}" class="exclusive_large button">
		{l s='Confirm Payment' mod='onemi'}
	   </a> -->
    </div>
</div>
