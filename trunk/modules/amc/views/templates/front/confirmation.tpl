<script type="text/javascript">
    //$(function () {
    //    setTimeout(function() {
    //        $("#redirect").submit();
    //    }, 5000);
   //    }) ;
</script>
{capture name=path}{l s='Your payment method'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}
<div class="container">
    <div class="contain-size">
        <div class="main">
            <div class="main-inner">
                <div class="col-main">
                    {*<br/>*}
                    {*<div class="breadcrumbs">*}

                        {*<a href="http://milagrow-dev.localhost.com/" title="Go to Home Page">Home</a>*}
                        {*<span class="navigation-pipe">&gt;</span>*}
                        {*<span class="navigation_page">Annual Maintenance Contract</span>*}

                        {*<span class="navigation-pipe">&gt;</span>*}
                        {*<span class="navigation_page">Your payment method</span>*}

                    {*</div>*}
                    {*<br/>*}
                    {*<div class="page-title">*}
                        {*<h1>PAY NOW</h1>*}
                    {*</div>*}
                    {*<p>You will now be redirected to the Payment Gateway where you can complete the payment process.*}
                        {*Thank you once again*}
                        {*for shopping with us, and we look forward to being in touch!</p>*}

                    {*<h6>If you are not automatically redirected to CCEAVENUE within 5 seconds, please click the button*}
                        {*below</h6>*}

                    {*<form method="post" id="redirect" name="redirect"*}
                          {*action="http://www.ccavenue.com/shopzone/cc_details.jsp">*}

                        {*<input type=hidden name=Merchant_Id value="{$merchant_id}">*}
                        {*<input type=hidden name=Amount value="{$amount}">*}
                        {*<input type=hidden name=Order_Id value="{$orderId}">*}
                        {*<input type=hidden name=Redirect_Url value="{$redirectLink}">*}
                        {*<input type=hidden name=Checksum value="{$checksum}">*}
                        {*<input type=hidden name=billing_cust_name value="{$billing_cust_name}">*}
                        {*<input type=hidden name=billing_cust_address value="{$billing_cust_address}">*}
                        {*<input type=hidden name=billing_cust_country value="{$billing_cust_country}">*}
                        {*<input type=hidden name=billing_cust_state value="{$billing_cust_state}">*}
                        {*<input type=hidden name=billing_cust_city value="{$billing_city}">*}
                        {*<input type=hidden name=billing_zip_code value="{$billing_zip}">*}
                        {*<input type=hidden name=billing_cust_tel value="{$billing_cust_tel}">*}
                        {*<input type=hidden name=billing_cust_email value="{$billing_cust_email}">*}
                        {*<input type=hidden name=billingPageHeading value="{$billingPageHeading}">*}
                        {*<input type=hidden name=delivery_cust_name value="{$delivery_cust_name}">*}
                        {*<input type=hidden name=delivery_cust_address value="{$delivery_cust_address}">*}
                        {*<input type=hidden name=delivery_cust_country value="{$delivery_cust_country}">*}
                        {*<input type=hidden name=delivery_cust_state value="{$delivery_cust_state}">*}
                        {*<input type=hidden name=delivery_cust_city value="{$delivery_city}">*}
                        {*<input type=hidden name=delivery_zip_code value="{$delivery_zip}">*}
                        {*<input type=hidden name=delivery_cust_tel value="{$delivery_cust_tel}">*}
                        {*<input type=hidden name=delivery_cust_email value="{$delivery_cust_email}">*}

                        {*<input type="submit" value="Pay Now" class="exclusive_large"/>*}
                    {*</form>*}

                    <div class="account-login">

                        <div class="paiement_block">


                            <h2>Please choose your payment method</h2>

                            <div id="HOOK_PAYMENT">
                                <div class="payment-main-block">
                                    <div class="payment-text-block">
                                        <span>Pay by Cheque</span><br>
                                        <span class="payment-description">Order Processing will take more time</span>
                                    </div>
                                    <div class="payment-button-block">
                                        <form action="/annual-maintenance-contract-payment-notification" method="post"
                                              id="cheque_payment_form" class="payment_module">
                                            <input type="hidden" name="paymentType" value="cheque" />
                                            <input type="hidden" name="order_id" value="{$orderId}" />
                                            <input type="submit" name="cheque" value="Confirm Payment" class="exclusive_large"/>
                                        </form>
                                    </div>
                                </div>


                                <div class="payment-main-block">
                                    <div class="payment-text-block">
                                        <span>Pay by Bank Wire</span><br>
                                        <span class="payment-description">Order Processing will be fastest</span>
                                    </div>
                                    <div class="payment-button-block">
                                        <form action="/annual-maintenance-contract-payment-notification" method="post"
                                              id="bankwire_payment_form" class="payment_module">
                                            <input type="hidden" name="paymentType" value="bankwire" />
                                            <input type="hidden" name="order_id" value="{$orderId}" />
                                            <input type="submit" name="bankwire" value="Confirm Payment" class="exclusive_large"/>
                                            {*<button class="exclusive_large"*}
                                            {*onclick="location.href='{$request_url}module/amc/payment/dochequePayment'">*}
                                            {*Confirm Payment*}
                                            {*</button>*}
                                        </form>
                                        {*<button class="exclusive_large" onclick="location.href='{$request_url}module/bankwire/payment'">*}
                                            {*Confirm Payment*}
                                        {*</button>*}
                                    </div>
                                </div>


                                <div class="payment-main-block">
                                    <div class="payment-text-block">
                                        <span>Credit Cards / Debit Cards / Net Banking / Cash Cards / Mobile Payments  </span><br><span
                                                class="payment-description">
        You may use any of the above options to make a payment.   </span>
                                    </div>
                                    <div class="payment-button-block">
                                        <form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post"
                                              id="ccAvenue_payment_form" class="payment_module">

                                            <input type=hidden name=Merchant_Id value="{$merchant_id}">
                                            <input type=hidden name=Amount value="{$amount}">
                                            <input type=hidden name=Order_Id value="{$orderId}">
                                            <input type=hidden name=Redirect_Url value="{$redirectLink}">
                                            <input type=hidden name=Checksum value="{$checksum}">
                                            <input type=hidden name=billing_cust_name value="{$billing_cust_name}">
                                            <input type=hidden name=billing_cust_address
                                                   value="{$billing_cust_address}">
                                            <input type=hidden name=billing_cust_country
                                                   value="{$billing_cust_country}">
                                            <input type=hidden name=billing_cust_state value="{$billing_cust_state}">
                                            <input type=hidden name=billing_cust_city value="{$billing_city}">
                                            <input type=hidden name=billing_zip_code value="{$billing_zip}">
                                            <input type=hidden name=billing_cust_tel value="{$billing_cust_tel}">
                                            <input type=hidden name=billing_cust_email value="{$billing_cust_email}">
                                            <input type=hidden name=billingPageHeading value="{$billingPageHeading}">
                                            <input type=hidden name=delivery_cust_name value="{$delivery_cust_name}">
                                            <input type=hidden name=delivery_cust_address
                                                   value="{$delivery_cust_address}">
                                            <input type=hidden name=delivery_cust_country
                                                   value="{$delivery_cust_country}">
                                            <input type=hidden name=delivery_cust_state value="{$delivery_cust_state}">
                                            <input type=hidden name=delivery_cust_city value="{$delivery_city}">
                                            <input type=hidden name=delivery_zip_code value="{$delivery_zip}">
                                            <input type=hidden name=delivery_cust_tel value="{$delivery_cust_tel}">
                                            <input type=hidden name=delivery_cust_email value="{$delivery_cust_email}">

                                            <input type="submit" value="Confirm Payment" class="exclusive_large"/>
                                        </form>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('.emi_disable').click(function (e) {
                                            e.preventDefault();
                                            var content = $('#fancybox-emi-error').html();
                                            $.fancybox(content);

                                        });
                                        $('a.iframe').fancybox();
                                    })
                                </script>


                            </div>


                            <div class="clearer"></div>
                        </div>

                    </div>

                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>
{*</div>*}