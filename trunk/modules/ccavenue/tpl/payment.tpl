<div class="payment-main-block">
    <div class="payment-text-block">
        <span>Credit Cards / Debit Cards / Net Banking / Cash Cards / Mobile Payments / <span style="color: #d32618; font-weight: bold;"> EMI </span> </span><br><span
                class="payment-description">
        You may use any of the above options to make a payment.
        </span>
    </div>
    <div class="payment-button-block">
        <form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post" id="ccAvenue_payment_form"
              class="payment_module">
            <input type=hidden name=Merchant_Id value="{$ccAvenue_merchant_id}">
            <input type=hidden name=Amount value="{$ccAvenue_amount}">
            <input type=hidden name=Order_Id value="{$ccAvenue_order_id}">
            <input type=hidden name=Redirect_Url value="{$ccAvenue_redirect_link}">
            <input type=hidden name=Checksum value="{$ccAvenue_checksum}">
            <input type=hidden name=billing_cust_name value="{$billing_cust_name}">
            <input type=hidden name=billing_cust_address value="{$billing_cust_address}">
            <input type=hidden name=billing_cust_country value="{$billing_cust_country}">
            <input type=hidden name=billing_cust_state value="{$billing_cust_state}">
            <input type=hidden name=billing_cust_city value="{$billing_city}">
            <input type=hidden name=billing_zip_code value="{$billing_zip}">
            <input type=hidden name=billing_cust_tel value="{$billing_cust_tel}">
            <input type=hidden name=billing_cust_email value="{$billing_cust_email}">
            <input type="submit" name="submit" value="Confirm Payment" class="exclusive_large">
        </form>
    </div>
</div>