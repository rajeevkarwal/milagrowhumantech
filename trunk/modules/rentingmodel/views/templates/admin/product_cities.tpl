<style>
.mytable tr td
    {
    text-align: center;
    height: 30px;
    }

</style>
<style>
	#error_msg
	{
		color:red;text-transfor:capitalize;
		}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
  
    function savePincode()
    {
        	
    	 var cityName = document.getElementById('cityValue').value;
    	 var pincodeName=document.getElementById('pincodeValue').value;
    	
//         var cate = e.options[e.selectedIndex].value;
         $.ajax(
                 {
                     type:'GET',
                     url:'/modules/rentingmodel/backCode.php?cityName='+cityName+'&pincodeName='+pincodeName,
                     success:function(data)
                     {
                         $data=jQuery.parseJSON(data);
                         if($data)
                         {
                        	 alert('New Pincode Added');
                        	 location.reload();
                         }
							
                     },

                 }
         )
    }
    
    function getid()
    {
        var productList ={$product}
        var e = document.getElementById('newCategory');

        var cate = e.options[e.selectedIndex].value;

        $('#product')
                .find('option')
                .remove()
                .end();
        var check = productList[cate];
        var opt = $('<option value="">--select--</option>');
        $('#product').append(opt);
        var elm = document.getElementById('product'),
                df = document.createDocumentFragment();
        for (var i = 0; i < check.length; i++) {
            var option = document.createElement('option');
            option.value = check[i]['id_product'];
            option.appendChild(document.createTextNode(" " + check[i]['product_name']));
            df.appendChild(option)

        }
        elm.appendChild(df);
    }
    {*function getCity()
    {
        var cityList ={$city}
      var e = document.getElementById('stateName');
        var cate = e.options[e.selectedIndex].value;
        $('#cityName')
                .find('option')
                .remove()
                .end();
        var check = cityList[cate];
        var opt = $('<option value="">--select City--</option>');
        $('#cityName').append(opt);
        var elm = document.getElementById('cityName'),
                df = document.createDocumentFragment();
        for (var i = 0; i < check.length; i++) {
            var option = document.createElement('option');
            option.value = check[i]['city'];
            option.appendChild(document.createTextNode(" " + check[i]['city']));
            df.appendChild(option)

        }
        elm.appendChild(df);

    }*}
   
</script>
   <center><b style="color:red;text-align:center">{$showMsg}</b></center>
<form name="addCity" id="addCity" method="post">
<table style="width: 50%;border:1px solid black;" align="center" class="mytable">
		
        <input type="hidden" value="saveCity" name="form_code">
        <tr>
            <td>Select Category</td>
            <td>
                {$category}
            </td>
        </tr>
        <tr>
             <td>Select Product</td>
            <td>
                <select name="product" id="product">
                        <option value="">select Products</option>
                </select>
            </td>
         </tr>
		<tr style="display:none">
			<td>Select State</td>
			<td>
				{$state}
			
			</td>
		</tr>
		<tr style="display:none;">
			<td>Select City</td>
			<td>
				<select name="cityName" id="cityName" onchange="getPincode();">
					<option>Select City Name</option>
				</select>
			
			</td>
		</tr>
		<tr>
		<td>Enter Pincode</td>
			{*<td>
				<input type="text" name="pincode" id="pincode" maxlength="6" required>			
			</td>*}
                        <td>
                        {$pincodes}
                        </td>
                        
		
		</tr>
		  
		 
		  <tr>
            <td colspan="2" align="center">
                <button name="submit" value="submit" type="submit" onclick="checkField();">Save Product</button>
            </td>
        </tr>
        <tr>
        	<td colspan="2"> <span id="error_msg"></span></td>
        </tr>


</table>
</form>
<hr>
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
border:2px solid #f2f2f2;
}
.row .col-md-6 input[type='button']
{
	height:25px;
	width:80px;
	padding:3px;
	
}
</style>
<div class="row">
	<div class="col-md-6">
		<center><h2>ADD NEW PINCODE</h2></center>
<table align="center">
	<tr>
		<td>Pincode</td><td align="right"><input type="text" value="" id="pincodeValue" name="pincodeValue" maxlength="6" required></td>
	</tr>
	<tr>
		<td>City Name</td><td align="right"><input type="text" value="" id="cityValue" name="cityValue" required></td>
	</tr>
	<tr>
		<td align="center" colspan="2"><input type="button" onclick="savePincode();" value="Save" class='btn btn-success btn-xs'></td>
	</tr>
	
</table>
	</div>
	<div class="col-md-6">
	<form method="post" enctype="multipart/form-data" action="#">
		<center><h2>IMPORT FROM CSV</h2></center>
		<table>
			<tr>
				<input type="hidden" name="form_code" value="csvimport">
				<td><label>Import From</label></td>
				<td><input type="file" name="pincodeImport" required><br></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" value="Upload" name="submit"></td>
				
			</tr>
		</table>
	
	
	</form>
		
	</div>
</div>

