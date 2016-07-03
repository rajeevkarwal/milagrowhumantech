
<table width="100%">
	<tr>
		
		<th>Order No</th>
		<th>Customer Email</th>
		<th>Product Category</th>
		<th>Product Name</th>
		<th>Application Status</th>
		<th colspan="3" align="center">Order Date Range</th>
	</tr>
	<tr>
		<td>
			<select name="customerOrder">
				<optgroup label="Order By Id"></optgroup>
				<option value="order by customer_id desc">Newest One</option>
				<option value="order by customer_id">Normal List</option>
			</select>
		
		</td>
		
		<td>
			<input type="email" name="customerEmail" title="Customer Email" Placeholder="Enter Customer Email">
		</td>
		
		<td>
				{$category}
			
		</td>
		
		<td>
			{$product}
		</td>
		<td>
			{$status}
		</td>
		<td colspan="2" align="center">
			<input type="date" name="fromDate">
					&nbsp;To&nbsp;
			<input type="date" name="toDate">
		</td>
		
		
	</tr>
	
</table>