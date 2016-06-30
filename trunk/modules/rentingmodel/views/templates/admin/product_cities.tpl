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
    function getPrice()
    {
      
        var e = document.getElementById('product');
        var cate = e.options[e.selectedIndex].value;
        $.ajax(
                {
                    type:'GET',
                    url:'http://localhost/practice/modules/rentingmodel/library.php?product_id='+cate,
                    success:function(data)
                    {
                        $data=jQuery.parseJSON(data);
                        if($data)

                            $('#initial_price').val($data.price);
                    },

                }
        )
    }
    function getid()
    {
        var productList ={$name}


        var e = document.getElementById('category');

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
    function getCityName()
    {
    	
         var pincode=document.getElementById('pincode').value;
         $.ajax(
                 {
                     type:'GET',
                     url:'/modules/rentingmodel/library.php?back_pincode='+pincode,
                     success:function(data)
                     {
                         $data=jQuery.parseJSON(data);
                         if($data)
                            document.getElementById('cityName').innerHTML=$data.name;
                     },

                 }
         )
    }
</script>
    {if !empty($ShowMsg)}
        <script>
            alert({$ShowMsg});
        </script>
        {/if}
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
                <select name="product" id="product" onchange="getPrice();">
                        <option value="">select Products</option>
                </select>
            </td>
         </tr>
		
		   <tr id="others" >
				<td>Enter Pincode</td>
				<td>
					<input type="number" maxlen="6" id="pincode" name="pincode" onkeyup="getCityName();"><br>
					<span id="cityName" style="color:red;text-transform: capitalize;"></span>
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
<table>
	<tr>
		<td></td>
	</tr>
	
</table>
