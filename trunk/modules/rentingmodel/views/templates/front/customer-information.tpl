<table style="width:100%;" cellpadding="1">
	<tr style="line-height:1">
		<th>Customer Name</th>
		<td>{$customerName}</td>
	</tr>
	<tr>
		<th>Customer Email</th>
		<td>{$customerEmail}</td>
	</tr>
	<tr>
		<th>Contact Number</th>
		<td>{$contactNumber}</td>
	</tr>
	<tr>
		<th>Your Address</th>
		<td>{$address}</td>
	</tr>
	<tr>
		<th>Monthly Rental</th>
		<td>{displayPrice curreny=1 price=$installmentAmount}</td>
	</tr>
	<tr>
		<th>Loan Status</th>
		<th>{if $status==1}{l s="Active"}{/if}{if $status==0}{l s='Inactive'} {/if}</th>
	</tr>
	<tr>
		<th colspan="2" align="center">
			<form method="post" id="redirect" name="redirect" action="http://www.ccavenue.com/shopzone/cc_details.jsp" onload="this.form.submit();">

                        <input type=hidden name=Merchant_Id value="{$merchant_id}">
                        <input type=hidden name=Amount value="{$installmentAmount}">
                        <input type=hidden name=Order_Id value="{$orderId}">
                        <input type=hidden name=Redirect_Url value="{$redirectLink}">
                        <input type=hidden name=Checksum value="{$checksum}">
                        <input type=hidden name=billing_cust_name value="{$customerName}">
                        <input type=hidden name=billing_cust_address value="{$address}">
                        <input type=hidden name=billing_cust_country value="india">
                        <input type=hidden name=billing_cust_state value="">
                        <input type=hidden name=billing_cust_city value="">
                        <input type=hidden name=billing_zip_code value="">
                        <input type=hidden name=billing_cust_tel value="{$contactNUmber}">
                        <input type=hidden name=billing_cust_email value="{$customerEmail}">
                        <input type=hidden name=billingPageHeading value="{$billingPageHeading}">
                        <input type=hidden name=delivery_cust_name value="{$customerName}">
                        <input type=hidden name=delivery_cust_address value="{$address}">
                        <input type=hidden name=delivery_cust_country value="india">
                        <input type=hidden name=delivery_cust_state value="">
                        <input type=hidden name=delivery_cust_city value="">
                        <input type=hidden name=delivery_zip_code value="">
                        <input type=hidden name=delivery_cust_tel value="{$contactNumber}">
                        <input type=hidden name=delivery_cust_email value="{$customerEmail}">
                        <input type="submit" value="Pay Now" class="exclusive_large"/>
             </form>
		</th>
	</tr>

</table>


