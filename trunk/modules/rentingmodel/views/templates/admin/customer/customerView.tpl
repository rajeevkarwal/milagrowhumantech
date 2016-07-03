
<script>
	function changeStatus()
	{
		var url={$ajaxurl}
		if(confirm('Do You Want To confirm'))
		{
			var status=$('#status').val();
			var rowid=$('#customerCode').val();
			 $.ajax(
		                {
		                    type:'GET',
		                    url:'/modules/rentingmodel/library.php?customerrowid='+rowid+'&status='+status,
		                    success:function(data)
		                    {
		                        $data=jQuery.parseJSON(data);
		                        if($data)
		                        {
			                        	if($data.statusCode)alert('Status Update Successfully');
			                        	else   	alert('Something went wrong');	
			                       }
		                    },
		                    error: function (xhr, ajaxOptions, thrownError) {
		                        alert(xhr.status);
		                        alert(thrownError);
		                      }})}}
	function deletePayment(document_number)
	{
		if(confirm('Do You Want To confirm'))
		{
			 $.ajax(
		                {
		                    type:'GET',
		                    url:'/modules/rentingmodel/library.php?chequeNumber='+document_number,
		                    success:function(data)
		                    {
		                        $data=jQuery.parseJSON(data);
		                        if($data.deleted)
		                        {
			                        alert('Cheque Deleted!PLease Refresh Page'+$data.deleted);	
			                   }
		                    },
		                    error: function (xhr, ajaxOptions, thrownError) {
		                        alert(xhr.status);
		                        alert(thrownError);
		                      }})}}

	function getMontlyRental()
	{
		
		 $.ajax(
		                {
		                    type:'GET',
		                    url:'/modules/rentingmodel/library.php?pro_id='+$('#product_id').val(),
		                    success:function(data)
		                    {
		                        $data=jQuery.parseJSON(data);
		                        if($data)
		                        	$('#installment_amount').val($data.installment_amount);
		                    },
		                    error: function (xhr, ajaxOptions, thrownError)
		                     {
		                        alert(xhr.status);
		                        alert(thrownError);
		                      }
		                 }
		          )
		}
</script>
<script>
 	function getMeta()
	{
			var x=document.getElementById('customerCode').value;
			var msg='';
			 $.ajax(
		                {
		                    type:'GET',
		                    url:'/modules/rentingmodel/library.php?CustomerCode='+x,
		                    success:function(data)
		                    {
		                        $data=jQuery.parseJSON(data);
		                        if($data)
		                        {
			                     	
									document.getElementById('customerName').innerHTML=$data.name;
									document.getElementById('customerEmail').innerHTML=$data.email;
									document.getElementById('customerDOB').innerHTML=$data.date_of_birth+$data.year_of_establishment;
									document.getElementById('customerNumber').innerHTML=$data.contact_number;
									document.getElementById('customerAddress').innerHTML=$data.address+','+$data.city+','+$data.state;
									document.getElementById('categoryName').innerHTML=$data.category_id;
									document.getElementById('productName').innerHTML=$data.product_id;
									document.getElementById('productAmount').innerHTML=$data.product_price;
									document.getElementById('securityDeposit').innerHTML=$data.security_deposited;
									document.getElementById('installmentAmount').innerHTML=$data.monthly_rental;
									document.getElementById('monthlyExpiration').innerHTML=$data.monthly_rental_expire;
									document.getElementById('tenureExpiration').innerHTML=$data.tenure_expiration_date;
									document.getElementById('activationDate').innerHTML=$data.applied_on;
									document.getElementById('paymentDuration').innerHTML=$data.payment_duration+'&nbsp;Months';
									if($data.pament_mode)
									document.getElementById('paymentMode').innerHTML='By Credit Card';
									else
										document.getElementById('paymentMode').innerHTML='By Cheque';	
									if($data.status==0)msg='awaiting approval';
									else if($data.status==1)msg='Document Verified';
									else if($data.status==2)msg='Product Sent';
									else if($data.status==3)msg='Product Delivered';
									else if($data.status==4)msg='Loan Active';
									else if($data.status==5)msg='Loan Completed';
									else if($data.status==6)msg='Loan Settelled';
									else if($data.status==7)msg='Loan Cancelled';
									else msg='Rejected';
									document.getElementById('currentStatus').innerHTML=msg;
										
		                        }
		                    }
		                }
		        )
	}
</script>
<style>
	table tr th{
		text-align:center;
		text-transform:capitalize;
		padding:5px;
	}
	table tr td{
		text-align:center;
		text-transform:capitalize;
		padding:5px;
		color:red;
	}
	table span{
		width:80px;
	}
</style>
<body onload="getMeta();">
	<input type="hidden" value="{$customer_id}" id="customerCode">
	<table align="center" width="50%;">
		<tr>
			<td colspan="4"><h3>Customer Detail</h3></td>
		
		</tr>
		<tr>
			<th>Customer Name</th>
			<td><span id="customerName"></span></td>
			<th>Customer Email</th>
			<td><span id="customerEmail"></span></td>
		</tr>
		
		<tr>
			<th>Date Of Birth</th>
			<td><span id="customerDOB"></span></td>
			<th>Contact Number</th>
			<td><span id="customerNumber"></span></td>
		</tr>
		<tr>
			<th>Address</th>
			<td colspan="3" id="customerAddress" style="text-align:left !important;"><span id="customerAddress"></span></td>
		</tr>
		<tr>	
			<td colspan="4"><h3>Product Details</h3></td>
		</tr>
		<tr>
			<th><span class="heading">Category Name</span></th>
			<td><span id="categoryName">LAPTOPS</span></td>
			<th><span class="heading">Product Name</span></th>
			<td><span id="productName">macbook Air</span></td>
		</tr>
		<tr>
			<th><span class="heading">Product Amount</span></th>
			<td>Rs.&nbsp;<span id="productAmount"></span></td>
			<th><span class="heading">Security Deposit</span></th>
			<td>Rs.&nbsp;<span id="securityDeposit"></span></td>
		</tr>
			<tr>
				<th colspan="4"><h3>Rental Description -</h3></th>
			</tr>
			<tr>
				<th><span class="heading">Installment Amount</span></th>
				<td>Rs.&nbsp;<span id="installmentAmount"></span></td>
				<th><span class="heading">Total Duration</span></th>
				<td><span id="paymentDuration"></span></td>
			</tr>
			<tr>
				<th><span class="heading">Montly Expiration</span></th>
				<td><span id="monthlyExpiration"></span></td>
				<th><span class="heading">Tenure Expiration Date</span></th>
				<td><span id="tenureExpiration"></span></td>
				
			</tr>
			<tr>
				<th><span class="heading">Payment Mode</span></th>
				<td><span id="paymentMode"></span></td>
				<th><span class="heading">Activation Date</span></th>
				<td><span id="activationDate"></span></th>
			</tr>
			<tr>
				<td colspan="4">
					<table align="center" style="border:1px solid black">
						<tr colspan="7" align="center">{$rentalMsg}</tr>
						<tr style="background-color:#d6c0b9;color:black !important;">
							<th>Customer Name</th>
							<th>Original Duration</th>
							<th>Is Extended</th>
							<th>Extended Duration</th>
							<th>Monthly Rental</th>
							<th>Updated On</th>
							<th>Action</th>
						</tr>
						{foreach from=$extendedPeriods key=store item=data}
							<form method="post">
								<input type="hidden" name="form_code" value="delete">
								<input type="hidden" name="extensionId" value="{$data['id']}">
								<input type="hidden" name="customerCode" value="{$data['customer_id']}">
								<input type="hidden" name="extendPeriod" value="{$data['extend_duration']}">
							<tr style="background-color:#d5d5e2;font-weight:400;">
								<td>{$customer_name}</td>
								<td>{$data['rent_duration']}&nbsp;Months</td>
								<td>{if $data['extend_period']==1}{l s='true'}{/if}</td>
								<td>{$data['extend_duration']} &nbsp;Months</td>
								<td>{displayPrice currency=1 price=$data['extended_rental']}</td>
								<td>{$data['datetime']}</td>
								<td><input type="submit" name="submit" value="Delete"></td>
							</tr>
							</form>
						{/foreach}
						<form method="post">
									<input type="hidden" name="form_code" value="saveExtendPeriod">
									<input type="hidden" id="product_id" name="product_id" value="{$product_id}">
						<tr>
							<td><input type="hidden" name="customer_id" value="{$customer_id}">{$customer_name}</td>
					<td><input type="hidden" name="original_duration" value="{$current_duration}">{$current_duration} Months</td>
					<td><input type="hidden" name="is_extended" value="1">True</td>
					<th>{$remaining_duration}</th>
				<td><input type="number" value="" name="extended_amount" id="installment_amount"></td>
				<th><input type="submit" name="submit" value="save"></th>
			</tr>
		</form>
					</table>
		</td>
			</tr>
			<tr>
				<td align="center" rowspan="2">
					<a href="{$img1}" target="_blank">
						<img src="{$img1}" height="120px" width="120px" title="Customer Image/Company Logo" alt="company image">
					</a>
					
				</td>
				<td rowspan="2"></td>
				<td rowspan="2"><a href="{$img2}" target="_blank">
						<img src="{$img2}' height="120px" width="120px" title="Customer Id Proof/Company Lease" alt="company lease">
					</a></td>
				<td rowspan="2"><a href="{$img3}" target="_blank">
						<img src='{$img3}' height="120px" width="120px" title="Customer Address proof/Proof of Properitership" alt="company pro">
					</a></td>
				
			</tr>
			<tr>
				
			</tr>
			<tr >
				<td><span class="heading">Current Status</span></td>
				<th><span id="currentStatus"></span></th>
				<td><span class="heading">New Status</span></td>
				<th>
					<span id="newStatus">
						{$status}			
					</span>
				</th>
			</tr>
			
			<tr>
				<th><a href="{$url}&tab_name=downloadLoanReceipt&customerNumber={$customer_id}" target="_blank"><button>Rent Receipt</button></a></th>
				<th><a href="{$url}&tab_name=downloadSecurityReceipt&customerNumber={$customer_id}"><button>Security Deposit Receipt</button></a></th>
				<th><a href="{$url}&tab_name=extendPeriod&customerNumber={$customer_id}"><button>Extend Period</button></a></th>
				<th><a href=""><button>Cancelled</button></a></th>
			</tr>
				
</table>
<br>

<br>

<table align="center" style="border:1px solid black;">
<tr style="background-color:#B7B7B7;font-weight:400;">
	<th>Payment Id</th>
	<th>Payment Type</th>
	<th>Customer Name</th>
	<th>Payment Received</th>
	<th>Payment Mode</th>
	<TH>Bank Name</TH>
	<th>Document Number</th>
	
	<th>Payment Timestamp</th>
	<th>Action</th>
</tr>
{if isset($previousPayments)}
{foreach from=$previousPayments key=stores item=payment}
	<tr style="background-color:#E0E3EF;font-weight:400;">
	<td>{$payment['payment_id']}</td>
	<td>
	{if $payment['status']==1}{l s="Monthly Rent"}{/if}
	{if $payment['status']==2}{l s="Security Deposit"}{/if}
	{if $payment['status']==3}{l s="Settlement Amount"}{/if}
	
	</td>
	
	<td>{$payment['name']}</td>
	<td style="color:blue !important;">{displayPrice currency=1 price=$payment['payment_received']}</td>
	<td>{if $payment['payment_mode']==0}{l s="By Cheque"}{/if}{if $payment['payment_mode']==1}{l s="By Transfer"}{/if}</td>
	<td>{$payment['bank_name']}</td>
	<td style="color:blue !important;">{$payment['document_number']}</td>
	<td>{$payment['DateTime']}</td>
	<td><button onclick="deletePayment({$payment['document_number']})">Delete</button></td>
	</tr>
{/foreach}
{/if}
	<tr style="background-color:#dccac4;">
		<td colspan="3"></td>
		
		<td>{displayPrice currency=1 price=$totalAmountReceived}</td>
		<td colspan="5"></td>
		
	</tr>
<form id="cheque_payment" name="cheque_payment" method="post">

<tr>
	<td><input type="hidden" value="payment" name="form_code"></td>
	<td><input type="hidden" name="customer_id" value="{$customer_id}"></td>
	<td><input type="number" value="{$installment}" name="amount_installment"  placeholder="Installment Amount"></td>
	<td><select name="payment_mode">
		<option value="0">By Cheque</option>
		<option value="1">By Transfer</option>
	</select></td>
	<td><input type="text" name="bank_name" id="bankName" placeholder="Bank Name" required></td>
	<td><input type="text" name="document_number" id="chequeNumber" placeholder="Cheque Number/Other" required></td>
	<td>
		<select name="status">
			<option value="1">Monthly Rent</option>
			<option value="2">Security Deposit</option>
			<option value="3">Settlement Amount</option>
		</select>
	</td>
	<td>
		<input name="submit" type="submit" value="saveCheque" onclick="this.form.submit();">
	</td>
	<td>
		
	</td>
	
</tr>
</form>
</table>
</body>

