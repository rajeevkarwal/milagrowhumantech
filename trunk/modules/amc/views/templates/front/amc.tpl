<link rel="stylesheet" media="all" type="text/css"
      href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"/>
<link rel="stylesheet" media="all" type="text/css" href="/js/jquery/plugins/timepicker/jquery-ui-timepicker-addon.css"/>
<link rel="stylesheet" media="all" type="text/css" href="{$jsSource}amc.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$jsSource}jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{$jsSource}amc.js"></script>

<script type="text/javascript">


    var productdata = new Array();

    $(document).ready(function () {
        {*productdata ={$productdata};*}
        var product = '{$product}';
        if (product != 'No product') {
            $("#product option[value='" + product + "']").attr('selected', 'selected');
            getPeriodList({$period});
        }

//        $('#product').change(function () {
//            getProducts();
//        });

        var ajaxurl = '{$ajaxurl}';

        var pincode = '{$pincode}';

        if (pincode) {
            var countryId = 110;
            if (countryId == 110) {
                if ($.trim(pincode)) {
                    $.ajax({
                        type: "GET",
                        url: ajaxurl + "pincodes/ajax.php?pincode=" + pincode,
                        success: function (data) {
                            if (data) {
                                data = jQuery.parseJSON(data);
                                console.log(data);
                                $('#city').val(data.city);
                                $('#state').val(data.id_state);
                            }
                            else {
                                alert('sorry currently we are not providing service in your area');
                                $('#state').val('');
                                $('#pincode').val('');
                                $('#city').val('');
                            }
                        }
                    });
                }
            }
        }
        $('#pincode').focusout(function () {
//            var countryId = $('#id_country option:selected').val();
            var countryId = 110;
            if (countryId == 110) {
                if ($.trim($(this).val())) {
                    $.ajax({
                        type: "GET",
                        url: ajaxurl + "pincodes/ajax.php?pincode=" + $.trim($(this).val()),
                        success: function (data) {
                            if (data) {
                                data = jQuery.parseJSON(data);
                                $('#city').val(data.city);
                                $('#state').val(data.id_state);
                            }
                            else {
                                alert('sorry currently we are not providing service in your area');
                                $('#state').val('');
                                $('#pincode').val('');
                                $('#city').val('');
                            }
                        }
                    });
                }
            }
        });

    });
    //    function getProducts(){
    //        var selectedproduct = $.trim($('#product option:selected').html());
    //
    //        for (key in productdata) {
    //            if (key == selectedproduct) {
    //                if (productdata[key]['amount'] == '0') {
    //                    alert('AMC is not offered on this model.Please choose another product for AMC');
    //                    $('#cost').val('-');
    //                    $('#duration').val('-');
    //                } else {
    //                    $('#cost').val(productdata[key]['amount']);
    //                    $('#duration').val(productdata[key]['duration']);
    //                }
    //            }
    //        }
    //    }
</script>

{capture name=path}{l s='Annual Maintenance Contract'}{/capture}
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
                    <h1>{l s='Request for Annual Maintenance Contract for Robots'}</h1>
                </div>
                {include file="$tpl_dir./errors.tpl"}

                <form id="amc" action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="cms-banner"
                      novalidate="" enctype="multipart/form-data">
                    <p class="cms-banner-img"><img alt="milagrow-trackorder-banner"
                                                   src="/img/cms/cms-banners/annual-maintenance-contract.png"></p>

                    <p>
                        As an esteemed Milagrow customer you can be rest assured that even after the expiry of warranty
                        period of
                        the product, you will continue to enjoy the same care and benefits through this extended
                        warranty plan which
                        will safeguard you against Uncertainty & Inconvenience.
                    </p>

                    <p><strong>Savings from unexpected high repair cost:</strong><br/>All the major operational parts
                        (no matter how
                        costly they are) & service charges are covered under this plan which comes to you at an
                        amazingly nominal
                        cost. </p>

                    <p>
                        <strong>Special service</strong><br/>
                        We have contracted with FedEx (World's No.1, Most Trusted Courier) to pickup the Robot(s) from
                        your
                        home/office in case of hardware failure or any other related problem.<br/>
                        We mostly receive them within 48-72 hours at company owned Service Centres at various places.
                        Mostly we
                        rectify it within 24-48 hours and send it back after perfect servicing and fine tuning.
                        Turnaround time for
                        you will be maximum 6-7 days in most cases..<br/>
                        We do not want our customers to suffer at the outsourced and ill equipped service centres. We
                        understand the
                        value of our customers and their time.
                        The above method is expensive for us but it is safer and faster for our customers.<br/>
                        We are committed to providing you with the best service and we have a strong ambition to be
                        India's most
                        respected service organization.
                    </p>

                    <p>
                        <strong>Assured and Unlimited Service </strong><br/>
                        In order to serve you in a competent manner we have got a dedicated team of engineers trained at
                        our own
                        service centres and are just a call away from you, for any kind of product related advice.
                    </p>

                    <p>
                        <strong>Comprehensive AMC</strong><br/>
                        Our comprehensive Annual Maintenance Contract is an industry benchmark and is designed to serve
                        you better.
                    </p>

                    <p>
                        <strong>Inclusions</strong><br/>
                        Electronic parts of main product shall be replaced/repaired, free of cost in case of any
                        breakdown during
                        AMC period as normal warranty.<br/>
                        {*<strong> PCB ,Wheels , Sensors , Display , Motors </strong> <br/>*}
                        {*Also covered..in addition are the following parts <br/>*}
                        {*<strong> Docking Station , Virtual Wall , Remote , Battery , Main Brush </strong><br/>*}

                        <strong>Exclusion</strong><br/>
                        {*<strong> Plastic Items , Filters , Mops , Side brushes</strong>*}
                        Decorative & Plastic parts, Consumables, Wear & Tear components however are not included.<br/>
                    </p>

                    <p>Take advantage of our extended service offer and enjoy the coverage provided to you even after
                        the expiry of
                        the original warranty period of the product.</p>

                    <p><strong>Genuine Spares and regular maintenance will help you in extending the life of your
                            Product.</strong>
                    </p>

                    <p>For further information regarding AMC prices etc. kindly contact us on
                        customercare@milagrow.in</p>
                    <br/>
                    <ul class="form-list">
                        <li>

                            <label for="name" class="required"><em>*</em>Name</label>

                            <div class="input-box">
                                <input type="text" id="name" name="name"
                                       value="{if isset($name)}{$name|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </div>
                        </li>
                        <li>
                            <label for="email" class="required"><em>*</em>Email</label>

                            <div class="input-box">
                                <input type="text" id="email" name="email"
                                       value="{if isset($email)}{$email|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </div>
                        </li>
                        <li>
                            <label for="mobile" class="required"><em>*</em>Mobile</label>

                            <div class="input-box">
                                <input type="text" id="mobile" name="mobile"
                                       value="{if isset($mobile)}{$mobile|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </div>
                        </li>
                        <li>
                            <label for="product" class="required"><em>*</em>Select Product</label>

                            <div class="input-box">
                                {$products}
                            </div>
                        </li>

                        <li id="textDiv">
                        </li>
                        
                        <li>
                            <label for="period" class="required"><em>*</em>Warranty Extension Period (Yrs)</label>
                            <div class="input-box">
                                <select name="period" id="period" onchange="getamtbyperiod()">
                                    <option value="Select Period">Select period</option>
                                </select>
                            </div>
                        </li>

                        

                        <li id="extendedcostli" style="display:none">
                            <label for="cost">Extended Warranty Cost for Additional Duration (Rs)<span style="display:none" id="extendedcostspan"></span></label>

                            <div class="input-box">
                                <input type="text" readonly id="cost" name="cost"/>
                            </div>
                        </li>

                        <li>
                            <label for="zip" class="required"><em>*</em>Zip Code</label>

                            <div class="input-box">
                                <input id="pincode" type="text" name="pincode"
                                       value="{if isset($pincode)}{$pincode|escape:'htmlall':'UTF-8'|stripslashes}{/if}"/>
                            </div>
                        </li>

                        <li>
                            <label for="city" class="required"><em>*</em>Select City</label>
                            <div class="input-box">
                                <input type="text" id="city" name="city"/>
                            </div>
                        </li>

                        <li>
                            <label for="state" class="required"><em>*</em>Select State</label>

                            <div class="input-box">
                                <select name="state" id="state">
                                    <option value="">{l s='-- Choose State --'}</option>
                                    {foreach from=$states item=state}
                                        <option value="{$state.id_state}">{$state.name|escape:'htmlall':'UTF-8'}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </li>


                        <li>
                            <label for="address" class="required"><em>*</em>Address</label>

                            <div class="input-box">
            <textarea id="address" name="address"
                      style="width:36%">{if isset($address)}{$address|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                            </div>
                        </li>


                        <li>
                            <label for="date" class="required"><em>*</em>Purchased Date</label>

                            <div class="input-box">
                                <input type="text" id="date" name="date"
                                       value="{if isset($date)}{$date|escape:'htmlall':'UTF-8'|stripslashes}{/if}"
                                       readonly/>
                            </div>
                        </li>

                        <li>
                            <label for="fileUpload" class="required">Attach Purchase Invoice<em>*</em>
                                (jpeg,png,jpg,pdf,doc,docx,rtf)</label>
                            <br/>If invoice is not available please attach the serial number photograph or photograph of
                            the product.

                            <div class="input-box">
                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                                <input type="file" name="fileUpload" id="fileUpload"/>
                            </div>
                        </li>

                        <li>
                            <label for="comments" class="required">Special Comments <em>*</em></label>

                            <div class="input-box">
                                <textarea name="special_comments"
                                          style="width:36%">{if isset($special_comments)}{$special_comments|escape:'htmlall':'UTF-8'|stripslashes}{/if}</textarea>
                            </div>
                        </li>
                        <input type="hidden" name="amc" value="amc"/>

                        <li class="text">
                            <label class="required" for="Captcha">{l s='Are you a human'} <strong>{$captchaText}
                                    <em>*</em></strong></label>

                            <div class="input-box">
                                <input type="text" name="captcha" id="captch"/>
                            </div>

                        </li>

                        <input type="hidden" name="captchaName" value="{$captchaName}">
                        <li>
                            <p class="required">*Required Fields</p>

                            <p class="required"><strong id="amount"></strong></p>
                            <button type="submit" name="submit" class="button">
                                <span><span>Submit</span></span>
                            </button><span id="ajax-loader" style="display: none"><img
                                        src="{$this_path}loader.gif"
                                        alt="{l s='loader' mod='amc'}"/></span>

                        </li>

                    </ul>


                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var amount = {$prodwiseamt};
    var warrantyList = {$pidWarrantyList};

            function getPeriodList(selectedPeriod) {
                $('#extendedcostli').hide();
                var e = document.getElementById('product');
                var cate = e.options[e.selectedIndex].value;
                $('#period')
                        .find('option')
                        .remove()
                        .end();
                $('#cost').val('');
                $('#extendedcostspan').val(0);
                $('#textDiv').html('');
                var result = amount[cate];
                var wPeriod = warrantyList[cate];
                if(wPeriod!="")
                {
                 $('#textDiv').html('<label>Normal Warranty Duration (Yrs)</label><div class="input-box"><input type="text" readonly value="'+wPeriod+'"/></div>');
                }
                var elm = document.getElementById('period'),
                df = document.createDocumentFragment();

                var opt = $('<option value=0>--select--</option>');
                $('#period').append(opt);
                for (var i = 0; i < result.length; i++) {
                    var option = document.createElement('option');
                    option.value = result[i]['product_period'];
                    option.appendChild(document.createTextNode(" " + result[i]['product_period']));
                    df.appendChild(option)

                }

                elm.appendChild(df);

                if(selectedPeriod)
                {
                    $('#period').val(selectedPeriod);
                    getamtbyperiod();
                }
            }

    function getAmount(productCode, period) {
        var prds = amount[productCode];
        var prdAmt = 0;
        $.each(prds, function (ind, val) {
            if (val["product_period"] == period)
                prdAmt = val["product_amount"];

        });
        $('#cost').val(prdAmt);
        $('#extendedcostspan').text(prdAmt);
        $('#extendedcostli').show();
        return prdAmt;
    }

    function getamtbyperiod() {
        var e = document.getElementById('product');
        var prod = e.options[e.selectedIndex].value;

        var e = document.getElementById('period');
        var period = e.options[e.selectedIndex].value;
        getAmount(prod, period);
    }


</script>
