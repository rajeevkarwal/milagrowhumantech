 
 
 	<body onload="document.redirect.submit();">
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
 					<form method="post" id="redirect" name="redirect" action="http://www.ccavenue.com/shopzone/cc_details.jsp" >
                        <input type=hidden name=Merchant_Id value="{$merchant_id}">
                        <input type=hidden name=Amount value="{$amount}">
                        <input type=hidden name=Order_Id value="{$orderId}">
                        <input type=hidden name=Redirect_Url value="{$redirectLink}">
                        <input type=hidden name=Checksum value="{$checksum}">
                        <input type=hidden name=billing_cust_name value="{$billing_cust_name}">
                        <input type=hidden name=billing_cust_address value="{$billing_cust_address}">
                        <input type=hidden name=billing_cust_country value="{$billing_cust_country}">
                        <input type=hidden name=billing_cust_state value="{$billing_cust_state}">
                        <input type=hidden name=billing_cust_city value="{$billing_city}">
                        <input type=hidden name=billing_zip_code value="{$billing_zip}">
                        <input type=hidden name=billing_cust_tel value="{$billing_cust_tel}">
                        <input type=hidden name=billing_cust_email value="{$billing_cust_email}">
                        <input type=hidden name=billingPageHeading value="{$billingPageHeading}">
                        <input type=hidden name=delivery_cust_name value="{$delivery_cust_name}">
                        <input type=hidden name=delivery_cust_address value="{$delivery_cust_address}">
                        <input type=hidden name=delivery_cust_country value="{$delivery_cust_country}">
                        <input type=hidden name=delivery_cust_state value="{$delivery_cust_state}">
                        <input type=hidden name=delivery_cust_city value="{$delivery_city}">
                        <input type=hidden name=delivery_zip_code value="{$delivery_zip}">
                        <input type=hidden name=delivery_cust_tel value="{$delivery_cust_tel}">
                        <input type=hidden name=delivery_cust_email value="{$delivery_cust_email}">

                       
                    </form>
                    </div>
              </div>
              </div>
              </div>
              
</body>