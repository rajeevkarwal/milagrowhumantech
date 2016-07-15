<h2>{$productName} Service Cities- <a href="{$url}&tab_name=addbulkpincode&productName={$productName}&productId={$productId}" style="color:red;font-size:18px;">Add Bulk Pincode</a></h2>
<style>
tr td,th{
text-transform: uppercase;
text-align:Center;
}
</style>
<style>
.row{
width:100%;
margin-top:20px;
color:black;
font-size:14px;
}
.row input[type="text"]
{
	width:80%;
}
.row .col-md-6{
float:left;
width:48%;
text-align:center;
border:2px solid #f2f2f2;
}
.row .col-md-6 input[type='button']
{
	height:25px;
	width:80px;
	padding:3px;
	
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
<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6" style="float:right;"> </div>
</div>
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

