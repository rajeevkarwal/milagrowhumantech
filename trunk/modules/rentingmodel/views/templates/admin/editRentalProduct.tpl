<style>
.mytable tr td
    {
    text-align: center;
    height: 30px;
    }

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
    function getPrice()
    {	
    	
        var value=document.getElementById("ProductId").value;
        $.ajax(
                {
                    type:'GET',
                    url:'/modules/rentingmodel/library.php?productCode='+value,
                    success:function(data)
                    {
                        $data=jQuery.parseJSON(data);
                        if($data)

                            $('#initial_price').val($data.product_value);
                        	$('#installment_amount').val($data.installment_amount);
                        	$('#security_deposit').val($data.security_value);
                        	$('#min_period').val($data.min_period);
                        	$('#max_period').val($data.max_period);
                        	$('#visit_per_month').val($data.visit_per_month);
                    },

                }
        )
    }
    
</script>
   <body onLoad='getPrice();'>
<form name="Add_Products" id="add_products" method="post" >
<table style="width: 50%;border:1px solid black;" align="center" class="mytable">
        <input type="hidden" value="edit" name="form_code">
       	<input type="hidden" value='{$id}' name="productId" id="ProductId">
        <tr>
             <td>Select Product</td>
            <td>
               <input type="text" name="product_name" value="{$name}" readonly="readonly">
            </td>
         </tr>
        <tr>
            <td>Product Amount</td>
            <td><input name="original_amount"  type="number" readonly="readonly" id="initial_price" readonly="readonly"></td>
        </tr>
        <tr>
            <td>Availabel For</td>
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
            <td>
                <table>
                    <tr id="percentage" name="percentage" style="display: none;">
                        <td>Enter Percentage</td>
                        <td><input name="percentage" type="number" max="100" min="1" id="percentage_value"> %</td>
                    </tr>
                    <tr id="amount" name="installation_amount" style="display: none;">
                        <td>Installment Amount</td>
                        <td>
                            <input name="installment_amount" type="number" maxlength="10" id="installment_amount" title="Installment Amount">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <script>
        function showmode()
        {
            var mode=document.getElementById('installment_mode').value;
            if(mode==='amount')
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

    </script>

        <tr>
            <td>Security Deposit</td>
            <td><input type="number" id="security_deposit" name="security_deposit" maxlength="10" onblur="checkmax();" required> </td>
        </tr>
        <tr>
            <td>Min Period</td>
            <td>
                <input type="number" id="min_period" name="min_period" max="24" min="1" required>
            </td>
        </tr>
        <tr>
            <td>Max Period</td>
            <td>
                <input type="number" id="max_period" name="max_period" max="24" min="3" required>
             </td>
        </tr>
        <tr>
            <td>Visit Per Month</td>
            <td><input type="number" id="visit_per_month" name="visit_per_month" min="1" required> </td>
        </tr>
        <tr>
        	<td>Status</td>
        	<td>
        		<select name="status" onchange="updateStatus()">
        				<option value="1">Active</option>
        				<option value="0">Inactive</option>
        		</select>
        	</td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <button name="submit" value="submit" type="submit" onclick="checkField();">Save Product</button>
            </td>
        </tr>


</table>
</form>
</body>