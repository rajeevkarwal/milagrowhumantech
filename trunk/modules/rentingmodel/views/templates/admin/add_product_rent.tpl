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
                    url:'/modules/rentingmodel/library.php?product_id='+cate,
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
</script>
    {if !empty($ShowMsg)}
        <script>
            alert({$ShowMsg});
        </script>
        {/if}
<form name="Add_Products" id="add_products" method="post">
<table style="width: 50%;border:1px solid black;" align="center" class="mytable">
        <input type="hidden" value="arp" name="form_code">
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
        <tr>
            <td>Product Amount</td>
            <td><input name="original_amount"  type="number" readonly="readonly" id="initial_price" required></td>
        </tr>
        <tr>
            <td>Available For</td>
            <td>
                <select id="available_for" name="available_for">
                    <option value="0">Indivisual</option>
                    <option value="1">Company</option>
                    <option value="2">Both</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Installment mode</td>
            <td>
                <select id="installment_mode" name="installment_mode" onchange="showmode();">
                    <option>Select Mode</option>
                    <option value="0">Percentage</option>
                    <option value="1">Amount</option>
                </select>
            </td>
                  
        </tr>
          <tr id="percentage" name="percentage" style="display: none;" align="center">
               <td>Enter Percentage</td>
               <td><input name="percentage" type="number" max="100" min="1" id="percentage_value"> %</td>
           </tr>
           <tr id="amount" name="installation_amount" style="display: none;" align="center">
                        <td>Installment Amount</td>
                        <td>
                            <input name="installment_amount" type="number" maxlength="10" id="installment_amount" title="Installment Amount">
                        </td>
          </tr>
    <script>
        function showmode()
        {
            var mode=document.getElementById('installment_mode').value;
            if(mode=='1')
                    {
                        document.getElementById('percentage').style.display='none';
                        document.getElementById('amount').style.display='block';
                    }
            else
                    {
                        document.getElementById('percentage').style.display='block';
                        document.getElementById('amount').style.display='none';
                    }

        }
		function checkmax()
		{
		
			var num1=parseInt(document.getElementById('deposite_amount').value);
			var num2=parseInt(document.getElementById('initial_price').value)
			
			if(num1>=num2)
			{
				
				document.getElementById('error_msg').innerHTML='Security Amount Should less then Product Amount';
				document.getElementById('deposite_amount').focus();
			}
			else
			{
				document.getElementById('error_msg').innerHTML='';
			}
		}
    </script>
        <tr>
            <td>Security Deposit</td>
            <td><input id="deposite_amount" type="number" name="security_deposit" maxlength="10" onblur="checkmax();" required>   </td>
        </tr>
        <tr>
            <td>Min Period</td>
            <td>
                <input type="number" name="min_period" max="24" min="1" required>
            </td>
        </tr>
        <tr>
            <td>Max Period</td>
            <td>
                <input type="number" name="max_period" max="24" min="3" required>
             </td>
        </tr>
        <tr>
            <td>Visit Per Month</td>
            <td><input type="number" id="visit_per_month" name="visit_per_month" min="1" required> </td>
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
