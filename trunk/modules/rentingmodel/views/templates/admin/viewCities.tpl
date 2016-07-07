<h2>{$productName} Service Cities</h2>
<style>
tr td,th{
text-transform: uppercase;
text-align:Center;
}
</style>
<script>
function deleteCity(id)
{
	
    
     $.ajax(
             {
                 type:'GET',
                 url:'/modules/rentingmodel/library.php?city_row_id='+id,
                 success:function(data)
                 {
                     $data=jQuery.parseJSON(data);
                     if($data==1)
                         $('#msg').val('Row Deleted Successfully');
                     else
                    	 $('#msg').val('Row Not Deleted Successfully');
                 },

             }
     )
}

</script>
<center>
	<h4><span id="msg"></span></h4>
</center>
<table align="center" width="100%">
	<tr style="background-color:#a5a5a5;padding:5px;">
		<th>Country</th>
		<th>State Name</th>
		<th>City Name</th>
		<th>Pincode</th>
		<th>Action</th>
	</tr>
	
	{foreach from=$available_city key=stores item=cityName}
	<tr style="background-color:#d2c2c2;padding:5px;">
		<td>India</td>
		<td>{$cityName['name']}</td>
		<td>{$cityName['city']}</td>
		<td>{$cityName['pincode']}</td>
		<td><input type="button" onclick="deleteCity({$cityName['id']});" value="Delete"></td>
	</tr>
	{/foreach}
</table>

