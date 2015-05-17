<link rel="stylesheet" media="all" type="text/css"
      href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
<link rel="stylesheet" media="all" type="text/css" href="/js/jquery/plugins/timepicker/jquery-ui-timepicker-addon.css"/>
<link rel="stylesheet" media="all" type="text/css" href="{$jsSource}demoregistration.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$jsSource}jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{$jsSource}demoregistration.js"></script>


<script type="text/javascript">
    var productdata = new Array();
    $(document).ready(function(){
		//$('#target').hide();
        productdata={$productdata};
        $('#product').change(function(){
            getCities();
         });
	  });
	


    function getCities(){
        var selectedproduct = $.trim($('#product option:selected').val());

        var cities = '';
        cities +=  '<option value="">Select City</option>';
        for(key in productdata){

        for(var i=0;i< productdata[key]['city'].length;i++){
                var city = productdata[key]['city'];
                if(key == selectedproduct){
                    var amount = productdata[key]['amount'];
                    cities +=  '<option value="' + city[i] + '">' + city[i] + '</option>';
                }
            }
        }
		cities +=  '<option value="other">Other Cities</option>';
        $('#city').html(cities);

        if(selectedproduct != 'select'){
			 var free = "'Free of Cost'";
            $('#amount').html('You need to pay Rs '+ amount +'/- for pre-sales, physical demo in cities where we offer this facility. Pressing Submit will take you to the payment page.<br/>For other cities we offer demo over Phone, Email and Skype, on a &#039;Free of Cost&#039; basis. Pressing Submit will confirm your demo request.');
			 alert('Please note that physical demo is available only in limited cities, on a chargeable basis. At other places we offer demo over Phone, Email and Skype, on a ' + free + ' basis.\nYou need to pay Rs ' + amount + '/- for this pre-sales, physical demo. Pressing Submit will take you to the payment page');
        }else{
            $('#amount').html("    ");
        }
		
		/*Add new text field for other city, if city name is not display in drop down list*/
			$('select').change(function(){
			if($(this).val()=="other")
    		$('#target').append( "<div id='other_city'><label for='other' class='required'><em>*</em>Insert City Name</label><div class='input-box'><input id='other' type='text' name='other_city'/></div></div>" );
			else
        	$('#other_city').remove();
			});
		/*end new text field*/

    }
</script>

{capture name=path}{l s='Book a demo'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

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
                <div class="page-title">
                    <h1>{l s='Request for Pre - Sales Home Demo for Robots'}</h1>
                </div>
		
        
				
        
                <form id="demo" action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" data-ajax="true"  class="cms-banner" novalidate="">
                    <p class="cms-banner-img"><img src="/img/cms/cms-banners/demo-page.png" alt="milagrow-book-demo"></p>
                    
                   
                    <p>
                        1.  Please fill the form below to submit your request for Pre-Sales Home Demo only. For Post-Purchase Demo pls fill the customer query form <a href="http://milagrowhumantech.com/customer-care">http://milagrowhumantech.com/customer-care</a>
                    </p>

                    <p> 2. We currently cover limited number of cities for Pre-Sales Demo  </p>

                    <p>3. Pre-Sales Demo at your home requires you to pay a nominal charge in advance which gets refunded upon Purchase.</p>

                    <p>4. The charges are refunded via a coupon code. When you pay the demo charges a coupon for equivalent amount will be mailed to you instantly. You may encash the same when you purchase the demonstrated model, from <a href="www.milagrowhumantech.com">www.milagrowhumantech.com</a> </p>
                    
                     <p>5. In addition to the above we welcome you to the Milagrow family with a Welcome Coupon of Rs.500/- which you can use to shop at our website on a minimum purchase of Rs. 4000.</p>

                    <p>6. Demo charges vary for various product categories based on the transportation requirements.</p>

                    <p>7. The customer care team will call you with-in 24 hrs after the form submission to confirm the date and time of demo.</p>

                    <p>8. Please note that the demo shall last for 30 minutes to an hour only, as per the product being demonstrated.</p>
                   
                    <br/>
                    <ul class="form-list">
                        <li>

                            <label for="name" class="required"><em>*</em>Name</label>

                            <div class="input-box">
                                <input type="text" id="name" name="name" />
                            </div>
                        </li>
                        <li>
                            <label for="email" class="required"><em>*</em>Email</label>

                            <div class="input-box">
                                <input type="email" id="email" name="email"/>
                            </div>
                        </li>
                        <li>
                            <label for="mobile" class="required"><em>*</em>Mobile</label>

                            <div class="input-box">
                                <input type="text" id="mobile" name="mobile"/>
                            </div>
                        </li>
                        <li>
                            <label for="product" class="required"><em>*</em>Select Product</label>

                            <div class="input-box">
                                {$products}
                            </div>
                        </li>
                        <li>
                            <label for="city" class="required"><em>*</em>Select City</label>

                            <div class="input-box">
                                <select name="city" id="city">
                                    <option value="">Select City</option>
                                 </select>
                            </div>
                        </li>
                        <li id="target">
                         <!-- <label for="other" class="required"><em>*</em>Insert City Name</label>
                        	  <div class="input-box">
                        	   <input id="other" type="text" name="other"/>
                               </div>-->
                               </li>
                               

                        <li>
                            <label for="address" class="required"><em>*</em>Address</label>

                            <div class="input-box">
                                <textarea id="address" name="address" style="width:36%"></textarea>
                            </div>
                        </li>

                        <li>
                            <label for="zip" class="required"><em>*</em>Zip Code</label>

                            <div class="input-box">
                                <input id="zip" type="text" name="zip"/>
                            </div>
                        </li>
                        <li>
                            <label for="date" class="required"><em>*</em>Preferred Date</label>

                            <div class="input-box">
                                <input type="text" id="date" name="date"  placeholder="" readonly/>
                            </div>
                        </li>

                        <li>
                            <label for="time" class="required"><em>*</em>Preferred Time</label>

                            <div class="input-box">
                                <input type="text" id="time" name="time"  placeholder="" readonly/>
                            </div>
                        </li>


                        <li>
                            <label for="comments">Special Comments</label>

                            <div class="input-box">
                                <textarea name="special_comments" style="width:36%"></textarea>
                            </div>
                        </li>
                        <input type="hidden" name="demo" value="demo"/>

                        {*<li>*}
                        {*<label for="price" class="required"><em>*</em>Price</label>*}

                        {*<div class="input-box">*}
                        {*<input type="text" id="price" readonly="readonly" name="price"*}
                        {*value="{$price}"/>*}
                        {*</div>*}
                        {*</li>*}
                        <li class="text">
                            <label class="required" for="Captcha">{l s='Are you a human'} <strong>{$captchaText}<em>*</em></strong></label>
                            <div class="input-box">
                                <input type="text" name="captcha" id="captch"/>
                            </div>

                        </li>

                        <input type="hidden" name="captchaName" value="{$captchaName}">
                        <li>
                            <p class="required">*Required Fields</p>
                            <p  class="required"><strong id="amount"></strong></p>
                            <button type="submit" name="submit" class="button">
                                <span><span>Submit</span></span>
                            </button><span id="ajax-loader" style="display: none"><img
                                        src="{$this_path}loader.gif"
                                        alt="{l s='loader' mod='demoregistration'}"/></span>

                        </li>

                    </ul>
                    
                    
                </form>

            </div>
        </div>
    </div>
</div>
