<script>
    function authenticate()
    {
        if (document.getElementById('customer_occupation').value == '')
            document.getElementById('customer_occupation').focus();
        else if (document.getElementById('name').value == '')
            document.getElementById('name').focus();
        else if (document.getElementById('email').value == '')
            document.getElementById('email').focus();
        else if (document.getElementById('contact_number').value == '')
            document.getElementById('contact_number').focus();
        else if (document.getElementById('address').value == '')
            document.getElementById('address').focus();
        else if (document.getElementById('pincode').value == '')
            document.getElementById('pincode').focus();
        else if (document.getElementById('category').value == '')
            document.getElementById('category').focus();
        else if (document.getElementById('product').value == '')
            document.getElementById('product').focus();
        else if (document.getElementById('loan_duration').value == '')
            document.getElementById('loan_duration').focus();
        else if (document.getElementById('initial_price').value == '')
            document.getElementById('initial_price').focus();
        else if (document.getElementById('security_deposit').value == '')
            document.getElementById('security_deposit').focus();
        else if (document.getElementById('installment_amount').value == '')
            document.getElementById('installment_amount').focus();
        else if (document.getElementById('agreement').value == '')
            document.getElementById('agreement').focus();
        else if (document.getElementById('file1').value == '')
            document.getElementById('file1').focus();
        else if (document.getElementById('file2').value == '')
            document.getElementById('file2').focus();
        else
            document.getElementById('d23').submit();

    }
    function applyDiscount()
    {

        var durationElement = document.getElementById('loan_duration');
        var duration = durationElement.options[durationElement.selectedIndex].value;
        
        var productElement = document.getElementById('product');
        var product_id = durationElement.options[productElement.selectedIndex].value;
        
        var categoryElement = document.getElementById('category');
        var category_id = durationElement.options[categoryElement.selectedIndex].value;
        
        
        //var duration = document.getElementById('loan_duration').value;
        //var product_id = document.getElementById('product').value;
        //var category_id = document.getElementById('category').value;

        if (duration === '')
        {
            document.getElementById('security_deposit').value = '';
            document.getElementById('installment_amount').value = '';
            document.getElementById('hidden_installment').value = '';
            document.getElementById('initial_msg').innerHTML = '';
            //document.getElementById('product').selectedIndex=0;
        } else if (category_id=== '')
        {
            document.getElementById('category').focus();
        } else if (product_id === '') {
            document.getElementById('product').focus();
        } else
        {
            getPrice(duration);

        }
    }
    function hideRow()
    {
        var mode = document.getElementById("payment_mod").value;
        if (mode === 'cheque')
        {
            document.getElementById('magic1').style.display = "block";
            document.getElementById('magic2').style.display = "block";
        } else
        {
            document.getElementById('magic1').style.display = "none";
            document.getElementById('magic2').style.display = "none";
        }
    }
    function checkDocument()
    {
        var address = document.getElementById("ad_proof").value;
        var id = document.getElementById("id_proof").value;
        if (address == id)
        {
            alert('Address Proof & ID Can Not Be Same');
        }
    }
    function enableTabs()
    {
        if (document.getElementById('name').value == '' || document.getElementById("contact_number").value == '' ||
                document.getElementById("email").value == '' || document.getElementById("dob").value == '' ||
                document.getElementById("address").value == ''
                )
            alert('Every Field Required');

        else
        {
            document.getElementById("product_tab").style.display = "block";
        }
    }

    /*
     * function need to be called on product change
     */
    function onProductChange()
    {
        var e = document.getElementById('product');
        var cate = e.options[e.selectedIndex].value;


        document.getElementById('zipcode').value = '';
        document.getElementById('security_deposit').value = '';
        document.getElementById('installment_amount').value = '';
        document.getElementById('loan_duration').selectedIndex = 0;
        document.getElementById('cityName').innerHTML = '';
    }


    function checkProductAvailability()
    {
        var e = document.getElementById('product');
        var cate = e.options[e.selectedIndex].value;

        if (cate != '')
        {
            var zipcode = document.getElementById('zipcode').value;
            $.ajax(
                    {
                        type: 'GET',
                        url: '/modules/rentingmodel/library.php?a_zipcode=' + zipcode + '&pid1=' + cate,
                        success: function (data)
                        {

                            $data = jQuery.parseJSON(data);
                            //console.log($data);
                            if (!('city' in $data))
                            {
                                document.getElementById('pincodeError').innerHTML = 'Currently Rental Service is only available to Delhi NCR';
                                document.getElementById('zipcode').value = '';
                                document.getElementById('zipcode').focus();
                            } else
                            {
                                document.getElementById('cityName').innerHTML = $data.city;
                                document.getElementById('pincodeError').innerHTML = '';
                            }

                        },
                        error: function (xhr, status, error) {
                            alert(status + error);
                        }
                    }
            )
        } else
        {
            alert('Please select the category and product');
        }

    }


    function getAuthentication1()
    {

        var zipcode = document.getElementById('zipcode').value;
        $.ajax(
                {
                    type: 'GET',
                    url: '/modules/rentingmodel/library.php?single_zip=' + zipcode,
                    success: function (data)
                    {
                        $data = jQuery.parseJSON(data);
                        if ($data.counter == 0)
                        {
                            document.getElementById('pincodeError').innerHTML = 'Currently Service Available in Delhi NCR Only';
                            document.getElementById('category').selectedIndex = 0;
                            document.getElementById('product').selectedIndex = 0;
                            document.getElementById('loan_duration').selectedIndex = 0;
                        } else
                        {
                            document.getElementById('pincodeError').innerHTML = '';
                            document.getElementById('category').selectedIndex = 0;
                            document.getElementById('product').selectedIndex = 0;
                            document.getElementById('loan_duration').selectedIndex = 0;
                        }
                    },
                    error: function (xhr, status, error)
                    {
                        alert(status + error);
                    }
                }
        )
    }

    function getid()
    {
        var productList ={$name}
        var e = document.getElementById('category');
        var cate = e.options[e.selectedIndex].value;

        document.getElementById('loan_duration').selectedIndex = 0;
        document.getElementById('security_deposit').value = '';
        document.getElementById('installment_amount').value = '';
        document.getElementById('zipcode').value = '';
        document.getElementById('pincodeError').innerHTML = '';
        document.getElementById('cityName').innerHTML = '';


        $('#product')
                .find('option')
                .remove()
                .end();

        var opt = $('<option value="">--Select Product Name--</option>');
        $('#product').append(opt);

        if (cate != '')
        {

            var check = productList[cate];

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

    }
    function getPrice(duration)
    {
        var e = document.getElementById('product');
        var cate = e.options[e.selectedIndex].value;
        //alert(duration);
        if (cate == '')
        {
            document.getElementById('installment_amount').value = '';
            document.getElementById('initial_msg').value = '';
        } else
        {

            $.ajax(
                    {
                        type: 'GET',
                        url: '/modules/rentingmodel/library.php?productCode=' + cate,
                        success: function (data)
                        {
                            $data = jQuery.parseJSON(data);
                            if ($data)
                            {
                                $('#initial_price').val($data.product_value);
                                $('#hidden_installment').val($data.installment_amount);
                                $('#security_deposit').val($data.security_value);
                                $('#installment_amount').val($data.installment_amount);
                                //document.getElementById('duration').attribute('min', $data.min_period);
                                //document.getElementById('duration').attribute('min', $data.max_period);
                                if (parseInt(duration) >= 9 && parseInt(duration) < 15)
                                {

                                    var amountSet = parseInt($data.installment_amount) - (parseInt($data.installment_amount) * 10 / 100);
                                    //alert(amountSet);
                                    document.getElementById('installment_amount').value = amountSet;
                                    document.getElementById('initial_msg').innerHTML = 'Duration Between 9 To 14 Month,You Got Discount 10%';
                                } else if (parseInt(duration) >= 15 && parseInt(duration) <= 24)
                                {

                                    var amountSet = parseInt($data.installment_amount) - (parseInt($data.installment_amount) * 15 / 100);
                                    document.getElementById('installment_amount').value = amountSet;
                                    document.getElementById('initial_msg').innerHTML = 'Duration More Than 15 Month,You Got Discount 15%';
                                } else
                                {
                                    //document.getElementById('installment_amount').value = '';
                                    document.getElementById('initial_msg').innerHTML = '';
                                }
                            }
                        },
                        error: function (xhr, status, error) {
                            alert(status + error);
                        }
                    }
            )


        }

    }
    function checkPincode()
    {
        var pincode = document.getElementById('zipcode').value;
        $.ajax(
                {
                    type: 'GET',
                    url: '/modules/rentingmodel/library.php?zipcode=' + pincode,
                    success: function (data)
                    {
                        $data = jQuery.parseJSON(data);
                        if ($data.counter == '1')
                        {
                            document.getElementById('pincodeError').innerHTML = 'Service Available for this Pincode';
                            document.getElementById('cityName').innerHTML = $data.name;
                            return true;
                        } else
                        {
                            document.getElementById('pincodeError').innerHTML = 'Currently This Facility is Available only in Delhi NCR';
                            document.getElementById('zipcode').focus();
                            return false;
                        }

                    },
                    error: function (xhr, status, error) {
                        alert(status + error);
                    }
                }
        )
    }
    function getCityName()
    {

        var pincode = document.getElementById('zipcode').value;
        if (pincode.length == 6)
        {
            $.ajax(
                    {
                        type: 'GET',
                        url: '/modules/rentingmodel/library.php?back_pincode=' + pincode,
                        success: function (data)
                        {

                            $data = jQuery.parseJSON(data);
                            if ($data.name)
                            {
                                document.getElementById('cityName').innerHTML = $data.name;
                                return true;
                            } else
                            {
                                document.getElementById('cityName').innerHTML = 'Invalid Pincode';
                                location.reload(1);
                            }




                        },
                        error: function (xhr, status, error) {
                            alert(status + error);
                        }
                    }
            )
        } else
        {
            document.getElementById('cityName').innerHTML = 'Please Enter Six Digit Pincode';
            document.getElementById('zipcode').focus();
        }


    }
    function checkAge()
    {
        var customer_occupation = document.getElementById('customer_occupation').value;
        if (!parseInt(customer_occupation))
        {
            var date = document.getElementById('dob').value.split('-');
            var year = date[0];
            var month = date[1];
            var day = date[2]
            var currentDate = new Date();
            var gap = parseInt(currentDate.getFullYear()) - parseInt(year);

            if (parseInt(gap) < 18 || parseInt(gap) >= 80)
            {
                document.getElementById('dob').focus();
                document.getElementById('dobError').innerHTML = 'Age Can be Less then 18 Year and not exceed then 80 Years';
            } else
                document.getElementById('dobError').innerHTML = '';
        } else
        {
            document.getElementById('doblabel').innerHTML = 'Date of Establishment';
            document.getElementById('image_msg').innerHTML = 'Proof of Propertietorship';
            document.getElementById('address_msg').innerHTML = 'Proof of Identity of Signatory';
            document.getElementById('id_proof_msg').innerHTML = 'Proof of Registered Office Address of Private and Public Limited Companies';

        }
    }
    function changeLabel()
    {
        var customer_occupation = document.getElementById('customer_occupation').value;
        if (parseInt(customer_occupation))
        {
            document.getElementById('establishment_id').style.display = 'block';
            document.getElementById('dob_id').style.display = 'none';
        } else
        {
            document.getElementById('dob_id').style.display = 'block';
            document.getElementById('establishment_id').style.display = 'none';
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
                <form id="d23" method="post"  enctype="multipart/form-data" onsubmit="return autheticate();">
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
                                <input type="text" maxlen="12"  id="contact_number" name="contact_number" value="" placeholder="10 Digit Number" required="required"/>
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
                                <select name="product" id="product" onchange="onProductChange();">
                                    <option value="">--Select Product Name--</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span3"><label for="name" class="required"><em>*</em>Pincode</label></div>
                        <div class="span9">
                            <div class="input-box">
                                <input type="text" value="" placeholder="Enter 6 Digit Pincode" name="zipcode" id="zipcode" maxlength="6" onblur="checkProductAvailability();" required="required">
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

                    <div class="row-fluid">
                        <div class="span3"><label for="name" class="required"><em>*</em>Address</label></div>
                        <div class="span9">
                            <div class="input-box">
                                <textarea class="form-control" name="address" id="address" required="required" placeholder="Enter Your Address"></textarea>
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
                                <input type="file" name="file3" id="file3" required/>
                                <button type="button" value="?" onclick="openDocuments1();">?</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <script>
                        function openDocuments()
                        {

                            var string1 = "Individuals\n - Images of recent Telephone Bills/ Electricity Bill/Property tax receipt/ Passport/ Voters ID card.\n" +
                                    "Company\n-Registered Office Address Proof and/or VAT certificate for Private or Public Limited Companies";
                            alert(string1);
                        }
                        function openDocuments1()
                        {

                            var string1 = "Individuals\n -Photocopies of Voters ID card/ Passport / Driving license/ IT PAN card / Aadhaar)" +
                                    " \nCompanies\n -Proprietorship/Partnership - Copy of PAN Card of Entity, Proprietors/Partners/Directors Proof of identity of signatory - Images of Voters ID card/ Passport / Driving license/ IT PAN card / Aadhaar.";
                            alert(string1);
                        }

                    </script>
                    <!--Agreement Button-->
                    <div class="row-fluid">
                        <input type="checkbox" id="agreement" value="Yes">&nbsp;&nbsp;&nbsp;<label>I Accept these  Terms & Conditions.&nbsp;<a href="/rental-terms-and-conditions" target="_blank" style="color:blue;">Please read the Agreement carefully</a>.</label>

                        <div style="margin-top:10px;">
                            <center>
                                <button  class="button" type="submit" style="width:100px;background-color: #ffa930 !important;height: 30px;color: white;">Save &amp; Next</button>

                            </center>
                        </div>
                    </div>


                </form>
            </div></div></div></div>