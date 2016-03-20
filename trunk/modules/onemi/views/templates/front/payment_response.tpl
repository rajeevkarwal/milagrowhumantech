{if $status == 'Ok'}
	<p class="success">
		{l s='Your order has been completed.' mod='onemi'}
		<br /><br />{$responseMsg}
		<br /><br />{l s='For any questions or for further information, please contact our' mod='onemi'} <a href="{$base_dir}contact-form.php">{l s='customer support' mod='onemi'}</a>.
		<br /><br />If you would like to view your order history please <a href="index.php?controller=history" title="{l s='History of Orders' mod='onemi'}">click here!</a>
	</p>
{else}
	<p class="error">
		{$responseMsg}
		<br /><br /><a href="{$base_dir}contact-form.php">{l s='customer support' mod='onemi'}</a>.
		<br /><br />If you would like to view your order history please <a href="index.php?controller=history" title="{l s='History of Orders' mod='onemi'}">click here!</a>
	<p></p>
{/if}
