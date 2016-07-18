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
<!-- Google Code for MilagrowHumantech Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 968875551;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "VZV0CJnS7xEQn7z_zQM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/968875551/?label=VZV0CJnS7xEQn7z_zQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
