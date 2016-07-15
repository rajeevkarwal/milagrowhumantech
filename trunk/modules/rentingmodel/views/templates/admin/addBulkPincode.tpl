<center>	
	<h2>{$productName}<i style="color:Red">{$ShowMsg}</i></h2>
</center>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
});

</script>
<style>

table tr th,td,label,span{
text-align:center;
}
</style>
<table width="100%" align="center">
<tr>
	<th><input type="checkbox" id="select-all"></th>
	<th><span>Pincode</span></th>
	<th><label>City</label></th>
</tr>
<form method="post" action="#"> 
<input type="hidden" name="productId" value='{$productId}'>
<input type="hidden" name="form_code" value="bulkPincodeInsert">
{foreach from=$pincode key=stores item=data}
	<tr>
		<td><input class="checkbox" type="checkbox" name="pincode[]" value="{$data['pincode']}" checked></td>
		<td><span>{$data['pincode']}</span></td>
		<td><label>{$data['city']}</label></td>
	</tr>
{/foreach}
	<tr>
		<td colspan="3">
			<input type="submit" name="submit" value="Save">
			</td>
	</tr>
</form>
</table>