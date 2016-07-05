<h2>{$productName} Service Cities</h2>
<style>
tr td,th{
text-transform: uppercase;
text-align:Center;
}
</style>
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
		<td><input type="button" onclick="" value="Delete"></td>
	</tr>
	{/foreach}
</table>

