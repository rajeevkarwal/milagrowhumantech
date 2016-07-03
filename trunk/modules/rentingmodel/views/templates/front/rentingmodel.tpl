<script>
	function authenticate()
	{
			if(document.getElementById('customer_occupation').value=='')
				document.getElementById('customer_occupation').focus();	
			else if(document.getElementById('name').value=='')
				document.getElementById('name').focus();	
			else if(document.getElementById('email').value=='')
				document.getElementById('email').focus();	
			else if(document.getElementById('contact_number').value=='')
				document.getElementById('contact_number').focus();	
			else if(document.getElementById('address').value=='')
				document.getElementById('address').focus();	
			else if(document.getElementById('category').value=='')
				document.getElementById('category').focus();
			else if(document.getElementById('product').value=='')
				document.getElementById('product').focus();
			else if(document.getElementById('loan_duration').value=='')
				document.getElementById('loan_duration').focus();
			else if(document.getElementById('initial_price').value=='')
				document.getElementById('initial_price').focus();
			else if(document.getElementById('security_deposit').value=='')
				document.getElementById('security_deposit').focus();
			else if(document.getElementById('installment_amount').value=='')
				document.getElementById('installment_amount').focus();
			else if(document.getElementById('agreement').value=='')
				document.getElementById('agreement').focus();
			else
				
				document.getElementById('d23').submit();
			
	}
	function applyDiscount()
	{
		
		var duration=document.getElementById('loan_duration').value;
		var amount=document.getElementById('hidden_installment').value
		 
		if(parseInt(duration)>=9 && parseInt(duration)<15)
		{		
				var amountSet=parseInt(amount)-(parseInt(amount)*10/100);
				 document.getElementById('installment_amount').value=amountSet;
				 document.getElementById('initial_msg').innerHTML='Duration Between 9 To 14 Month,You Got Discount 10%';
		}
		else if(parseInt(duration)>=15 && parseInt(duration)<=24)
		{
			 var amountSet=parseInt(amount)-(parseInt(amount)*15/100);
			 document.getElementById('installment_amount').value=amountSet;
			 document.getElementById('initial_msg').innerHTML='Duration More Than 15 Month,You Got Discount 15%';
		}
		else
		{
			 document.getElementById('installment_amount').value=amount;
			 document.getElementById('initial_msg').innerHTML='';	 
		}
	}
	function hideRow()
	{
		var mode=document.getElementById("payment_mod").value;
		if(mode==='cheque')
		{
			document.getElementById('magic1').style.display="block";
			document.getElementById('magic2').style.display="block";
		}
		else
		{
			document.getElementById('magic1').style.display="none";
			document.getElementById('magic2').style.display="none";
		}
	}
	function checkDocument()
	{
		var address=document.getElementById("ad_proof").value;
		var id=document.getElementById("id_proof").value;
		if(address==id)
		{
			alert('Address Proof & ID Can Not Be Same');
		}
	}
	function enableTabs()
	{
		if(document.getElementById('name').value=='' || document.getElementById("contact_number").value==''||
				document.getElementById("email").value=='' || document.getElementById("dob").value=='' ||
				document.getElementById("address").value==''
		) alert('Every Field Required');

		else
		{
			document.getElementById("product_tab").style.display="block";
		}
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
	function getPrice()
	{
		var e = document.getElementById('product');
		var cate = e.options[e.selectedIndex].value;

		$.ajax(
				{
					type:'GET',
					url:'/modules/rentingmodel/library.php?productCode='+cate,
					success:function(data)
					{

						$data=jQuery.parseJSON(data);
						if($data)
						{
							$('#initial_price').val($data.product_value);
							$('#hidden_installment').val($data.installment_amount);
							$('#security_deposit').val($data.security_value);
							$('#installment_amount').val($data.installment_amount);
							document.getElementById('duration').attribute('min',$data.min_period);
							document.getElementById('duration').attribute('min',$data.max_period);
						}

					},
					error: function(xhr, status, error) {
						alert(status+error);
					}
				}
		)
	}
	function checkPincode()
	{
			
		var pincode=document.getElementById('zipcode').value;
		$.ajax(
				{
					type:'GET',
					url:'/modules/rentingmodel/library.php?zipcode='+pincode,
					success:function(data)
					{

						$data=jQuery.parseJSON(data);
						if($data.counter=='1')
						{
							document.getElementById('pincodeError').innerHTML='Service Available for this Pincode';
							document.getElementById('cityName').innerHTML=$data.name;
							return true;
						}
						else
						{
							document.getElementById('pincodeError').innerHTML='Currently This Facility is Available only in Delhi NCR';
							document.getElementById('zipcode').focus();
							return false;
						}

					},
					error: function(xhr, status, error) {
						alert(status+error);
					}
				}
		)
		
	}
	function getCityName()
	{
			
		var pincode=document.getElementById('zipcode').value;
		$.ajax(
				{
					type:'GET',
					url:'/modules/rentingmodel/library.php?back_pincode='+pincode,
					success:function(data)
					{

						$data=jQuery.parseJSON(data);
						if($data.name)
						{
							
							document.getElementById('cityName').innerHTML=$data.name;
							return true;
						}
						

					},
					error: function(xhr, status, error) {
						alert(status+error);
					}
				}
		)
		
	}
	function checkAge()
	{
		var customer_occupation=document.getElementById('customer_occupation').value;
		if(!parseInt(customer_occupation))
		{
				var date=document.getElementById('dob').value.split('-');
				var year=date[0];
				var month=date[1];
				var day=date[2]
				var currentDate=new Date();
				var gap=parseInt(currentDate.getFullYear())-parseInt(year);
			
				if(parseInt(gap)<18 || parseInt(gap)>=80)
				{
						document.getElementById('dob').focus();
						document.getElementById('dobError').innerHTML='Age Can be Less then 18 Year and not exceed then 80 Years';
				}
				else
				document.getElementById('dobError').innerHTML='';
		}
		else
		{
			document.getElementById('doblabel').innerHTML='Date of Establishment';
			document.getElementById('image_msg').innerHTML='Proof of Propertietorship';
			document.getElementById('address_msg').innerHTML='Proof of Identity of Signatory';
			document.getElementById('id_proof_msg').innerHTML='Proof of Registered Office Address of Private and Public Limited Companies';
			
		}
	}
	function changeLabel()
	{
		var customer_occupation=document.getElementById('customer_occupation').value;
		if(parseInt(customer_occupation))
		{
			document.getElementById('establishment_id').style.display='block';
			document.getElementById('dob_id').style.display='none';
		}
		else
		{
			document.getElementById('dob_id').style.display='block';
			document.getElementById('establishment_id').style.display='none';
		}
	}
	
</script>
<div class="main">
    <div class="main-inner">
        <div class="row-fluid show-grid">
            {if $themesdev.td_siderbar_without=="enable"}
                <div class="col-left sidebar span3">
                    {$HOOK_LEFT_COLUMN}
                    {$themesdev.td_left_sidebar_customhtml|html_entity_decode}

                </div>
            {/if}
			<div class="span9">
				<div class="page-title"><h1>{l s='Rent a Milagrow Robot'}</h1></div>
				<p>
					Many customers have approached us over the last few years to rent our robots. We are starting our rental project on persistent public demand.</p>
				<p>
					We understand that these new age products need the support of the early tech adapters.
					 Good consumer experience is essential to develop the robots category.
					 Being India's no.1 consumer robots, we take our responsibility to develop this market very seriously.
				</p>
				<p>
					Customer centricity defines every action at Milagrow. During the rental period we will visit the customer's home or office atleast once every month & take care of maintenance & consumables of the product.
					
				</p>
				<p>
				Currently we have opened the rental facility in Delhi NCR only. We will shortly open it in other parts of India as well.
				<br>You can apply for it online Here
				</p>
                    <br/>
				 {include file="$tpl_dir./errors.tpl"}
				
				<style>
					.span3{
					position:relative !important
					}
				</style>
			<form id="d23" method="post" enctype="multipart/form-data" >
						<div class="row-fluid">
								<div class="span3"><label for="name" class="required"><em>*</em>Your Occupation</label></div>
									<div class="span9">
										<div class="input-box">
												{$occupation}
										</div>
									</div>
						</div>
						
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Your Name</label></div>
							<div class="span9">
								<div class="input-box">
									<input type="text" id="name" class="form-control" name="name" value="{$loginname}" placeholder="Your Name" title="Your Name" required="required"/>
								</div>
								<span id="msg"></span>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Your Email</label></div>
							<div class="span9">
								<div class="input-box">
									<input type="text" id="email" class="form-control" name="email" value="{$email}" placeholder="Your Email" title="Your Email ID" required="required"/>
								</div>
							</div>
						</div>
						<div class="row-fluid" id="establishment_id" style="display:none">
							<div class="span3"><label for="name" class="required"><em>*</em>Year of Establishment</label></div>
							<div class="span9">
								<div class="input-box">
									<input type="text" id="year_of_establishment" class="form-control" name="establishment_year"  />
								</div>
							</div>
						</div>
						
						
						<div class="row-fluid" id="dob_id">
							<div class="span3"><label for="name" class="required"><em>*</em><span id="doblabel">Date of Birth</span></label></div>
							<div class="span9">
								<div class="input-box">
									<input type="date" name="date_of_birth" class="form-control" id="dob" onblur="checkAge();" value="{$bday}" />
									<span id="dobError" style="color:red"></span>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Contact Number</label></div>
							<div class="span9">
								<div class="input-box">
									<input type="text" maxlen="12" pattern="[0-9]" id="contact_number" name="contact_number" value="" placeholder="10 Digit Number" title="Your Name" required="required"/>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Address</label></div>
							<div class="span9">
								<div class="input-box">
									<textarea class="form-control" name="address" id="address" required="required" placeholder="Enter Your Address"></textarea>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Pincode</label></div>
							<div class="span9">
								<div class="input-box">
									<input type="text" value="" name="zipcode" id="zipcode" maxlength="6" onkeyup="getCityName();" onblur="return checkPincode();" required="required">
									<span id="pincodeError" style="color:red"></span>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>City</label></div>
							<div class="span9">
								<div class="input-box">
									<span id="cityName" style="text-transform: capitalize"></span>
									
								</div>
							</div>
						</div>
						
								
	<!--Product Information Tab-->
   						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Product Category</label></div>
							<div class="span9">
								<div class="input-box">
									{$db_cat}
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Product Name</label></div>
							<div class="span9">
								<div class="input-box">
									<select name="product" id="product" onchange="getPrice();">
										<option>--Select Product Name--</option>

									</select>
								</div>
							</div>
						</div>
		
	<!--Rent Details Tab-->
   
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Rent Duration</label></div>
							<div class="span9">
								<div class="input-box">
									{$duration}
								</div>
							</div>
						</div>
						<div class="row-fluid" style="display:none">
							<div class="span3"><label for="name" class="required"><em>*</em>Product Value</label></div>
							<div class="span9">
								<div class="input-box">
									<input type="text" readonly="readonly" id="initial_price" class="form-control" name="product_price"  placeholder="" title="Your Email ID" required="required"/>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Security Deposit</label></div>
								<div class="span9">
									<div class="input-box">
										<input type="text" readonly="readonly" id="security_deposit" name="security_deposited" class="form-control" name="name" value="" placeholder="" title="Your Email ID" required/>
									</div>
								</div>
							</div>
						<div class="row-fluid">
							<div class="span3"><label for="name" class="required"><em>*</em>Monthly Rental</label></div>
							<div class="span9">
								<div class="input-box">
								<input type="hidden" id="hidden_installment" value=""> 
									<input type="number" readonly="readonly" name="monthly_rental" id="installment_amount" class="form-control" required/>
										<span id="initial_msg"></span>
								</div>
							</div>
						</div>
						
						
						<div class="row-fluid" id="magic2" style="display:none;">
								<div class="span3"><label for="name" class="required" >
									<span id="image_msg">Your Image</span></label>
								</div>
							<div class="span9">
								<div class="input-box">
								 <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
									<input type="file" name="file1" id="file1">
									
								</div>
								
							</div>
						</div>
						<div class="row-fluid" id="magic2" >
								<div class="span3">
									<label for="name" class="required" ><em>*</em>
									
										<label id="address_msg">Proof of Residence</label>
									</label>
								</div>
							<div class="span9">
								<div class="input-box">
								 <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
									<input type="file" name="file2" id="file2" required/>
									<button type="button" value="?" onclick="openDocuments();">?</button>
								</div>
								
						</div>
						</div>
						<div class="row-fluid" id="magic2" >
									<div class="span3"><label for="name" class="required"><em>*</em><span  id="id_proof_msg">Proof of Identity</span></label></div>
							<div class="span9">
								<div class="input-box">
								 <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
									<input type="file" name="file3" id="file3"/>
									<button type="button" value="?" onclick="openDocuments1();">?</button>
								</div>
							</div>
						</div>
		<br>
		<script>
			function openDocuments()
			{
				
				var string1 ="Individuals\n - Images of recent Telephone Bills/ Electricity Bill/Property tax receipt/ Passport/ Voters ID card.\n"+
					"Company\n-Registered Office Address Proof and/or VAT certificate for Private or Public Limited Companies";
					alert(string1);
			}
			function openDocuments1()
			{
				
				var string1 ="Individuals\n -Photocopies of Voters ID card/ Passport / Driving license/ IT PAN card / Aadhaar)"+
					" \nCompanies\n -Proprietorship/Partnership - Copy of PAN Card of Entity, Proprietors/Partners/Directors Proof of identity of signatory - Images of Voters ID card/ Passport / Driving license/ IT PAN card / Aadhaar.";
					alert(string1);
			}
				
		</script>
					<!--Agreement Button-->
						<div class="row-fluid">
								<input type="checkbox" id="agreement" value="Yes">&nbsp;&nbsp;&nbsp;<label>I Accept these  Terms & Conditions.&nbsp;<a href="/rental-terms-and-conditions" target="_blank" style="color:blue;">Please read the Agreement carefully</a>.</label>
							
										<div style="margin-top:10px;">
									<center>
										<button onclick="return authenticate();" class="button" type="button" style="width:100px;background-color: #ffa930 !important;height: 30px;color: white;">Save &amp; Next</button>

									</center>
										</div>
							</div>

						
		</form>
</div></div></div></div>