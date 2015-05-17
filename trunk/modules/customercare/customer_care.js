$(document).ready(function () {
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }

    function validatePhone(txtPhone) {

        var filter = /^\d{10}$/;
        return filter.test(txtPhone);

    }

    var selectedProduct = $("#product option:selected").val();
    getPurpose(selectedProduct);

    $("#category").val($('#purpose').val()).attr('selected','selected');

//
    $('input[type=radio][name=existingCustomer]').change(function () {
        var category = $('#category');
        var selectProduct = $("#product option:selected").val();
        category.html('');
        var optionStr = "<option value=''>Select Purpose</option>";
        if (this.value == 'yes') {
            if (selectProduct == 'TabTops') {

                optionStr +=
                    "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                        "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                        "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                        "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                        "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                        "<option value=\"Accessories Query\">Accessories Query</option>  " +
                        "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                        "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";


            }if (selectProduct == 'Robotic Vacuum Cleaners') {

                optionStr +=
                    "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                        "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                        "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                        "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                        "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                        "<option value=\"Accessories Query\">Accessories Query</option>  " +
                        "<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                        "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                        "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";


            } else if (selectProduct == "Robotic Window Cleaners") {

                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
					"<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";

            } else if (selectProduct == "Pool Robots") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
					"<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";

            } else if (selectProduct == "Lawn Robots") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
					"<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";

            } else if (selectProduct == "Air Purifiers") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";

            } else if (selectProduct == "Robotic Body Massagers") {

                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  ";

            } else if (selectProduct == "TV Mounts and Racks") {

                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  ";

            } else if (selectProduct == "Accessories") {
                optionStr += "<option value=\"Post Sales – Query\" >Post Sales – Query</option>";
            }

        } else {
            if (selectProduct == 'TabTops') {

                optionStr +=
                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            } else if (selectProduct == 'Robotic Vacuum Cleaners') {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            } else if (selectProduct == "Robotic Window Cleaners") {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            } else if (selectProduct == "Pool Robots") {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            } else if (selectProduct == "Lawn Robots") {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            } else if (selectProduct == "Air Purifiers") {
                optionStr +=
                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>" +
                        "<option value=\"Pre Sales – General\">Pre Sales – General</option>";

            } else if (selectProduct == "Robotic Body Massagers") {
                optionStr +=
                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            } else if (selectProduct == "TV Mounts and Racks") {
                optionStr +=

                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";

            }else if (selectProduct == "Accessories") {
                optionStr += "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }

        }
        category.append(optionStr);
    });

    $('#product').on('change', function (e) {

      getPurpose(this.value);
    });

    $('#category').on('change', function (e) {

        var selectedProduct = $("#product option:selected").val();
        var existingCustomer = $('input:radio[name=existingCustomer]:checked').val();

        if (this.value == 'Installation (Product in Warranty)' && selectedProduct == "TabTops") {
            alert("Please note that in case of In-warranty Taptops, installation help is available only over Phone, Email and Skype.");
        }
        else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "TabTops")
            alert("Please note that in case of In-warranty Taptops, demo is available only over Phone, Email and Skype.");
			 

        else if (this.value == "Software Issue (Product in Warranty)" && selectedProduct == "TabTops")
            alert("Please note that in case of In-warranty Taptops, help for software related issues is available only over Phone, Email and Skype.");

        else if (this.value == "Pre Sales – Demo" && selectedProduct == "Robotic Vacuum Cleaners") {
            alert("Please note that in case of Pre- Sales, 'physical' demo is available only in limited cities, on a chargeable basis. At other places we offer demo over Phone, Email and Skype, on a 'Free of Cost' basis.");
            window.location.href ="/book-demo";
        }
        else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "Robotic Vacuum Cleaners")
            alert("Please note that in case of Post-Sales, 'physical' demo is available only in limited cities. At other places we offer demo over Phone, Email and Skype.");
		
			
		else if (this.value == "Warranty Extension" && selectedProduct == "Robotic Vacuum Cleaners")
           // alert("Please note that in case of Post-Sales, 'physical' demo is available only in limited cities. At other places we offer demo over Phone, Email and Skype.");
		    window.location.href ="annual-maintenance-contract";
			
		else if (this.value == "Warranty Extension" && selectedProduct == "Pool Robots")
             window.location.href ="annual-maintenance-contract";
			 
		else if (this.value == "Warranty Extension" && selectedProduct == "Lawn Robots")
             window.location.href ="annual-maintenance-contract";
			 
		else if (this.value == "Warranty Extension" && selectedProduct == "Robotic Window Cleaners")
             window.location.href ="annual-maintenance-contract";
			

        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "Robotic Vacuum Cleaners")
            alert("Please note that In-warranty Installation is available only in limited cities. At other places we offer installation help over Phone, Email and Skype.");

        else if (this.value == "Software Issue (Product in Warranty)" && selectedProduct == "Robotic Vacuum Cleaners")
            alert("Please note that in case of In-warranty Robotic Floor Cleaners, help for software related issues is available only over Phone, Email and Skype.");

        else if (this.value == "Pre Sales – Demo" && selectedProduct == "Robotic Window Cleaners") {
            alert("Please note that in case of Pre- Sales, 'physical' demo is available only in limited cities, on a chargeable basis. At other places we offer demo over Phone, Email and Skype, on a 'Free of Cost' basis.");
            window.location.href ="/book-demo";
        }else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "Robotic Window Cleaners")
            alert("Please note that in case of Post-Sales, 'physical' demo is available only in limited cities. At other places we offer demo over Phone, Email and Skype.");
			

        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "Robotic Window Cleaners")
            alert("Please note that In-warranty Installation is available only in limited cities. At other places we offer installation help over Phone, Email and Skype.");

        else if (this.value == "Software Issue (Product in Warranty)" && selectedProduct == "Robotic Window Cleaners")
            alert("Please note that in case of In-warranty Robotic Window Cleaners, help for software related issues is available only over Phone, Email and Skype.");

        else if (this.value == "Pre Sales – Demo" && selectedProduct == "Pool Robots") {
            alert("Please note that in case of In-warranty Pool Robots, in person demo is available only in four cities i.e.,Bangalore, Delhi/NCR, Pune and Mumbai.");
            window.location.href ="/book-demo";
        }else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "Pool Robots")
            alert("Please note that in case of Post-Sales, 'physical' demo is available only in limited cities. At other places we offer demo over Phone, Email and Skype.");
			
        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "Pool Robots")
            alert("Please note that In-warranty Installation is available only in limited cities. At other places we offer installation help over Phone, Email and Skype.");
        else if (this.value == "Software Issue (Product in Warranty)" && selectedProduct == "Pool Robots")
            alert("Please note that in case of In-warranty Pool Robots, help for software related issues is available only over Phone, Email and Skype.");

        else if (this.value == "Pre Sales – Demo" && selectedProduct == "Lawn Robots") {
            alert("Please note that in case of Pre- Sales, 'physical' demo is available only in limited cities, on a chargeable basis. At other places we offer demo over Phone, Email and Skype, on a 'Free of Cost' basis.");
            window.location.href ="/book-demo";
        }else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "Lawn Robots")
            alert("Please note that in case of Post-Sales, 'physical' demo is available only in limited cities. At other places we offer demo over Phone, Email and Skype.");
			
        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "Lawn Robots")
            alert("Please note that In-warranty Installation is available only in limited cities. At other places we offer installation help over Phone, Email and Skype.");
        else if (this.value == "Software Issue (Product in Warranty)" && selectedProduct == "Lawn Robots")
            alert("Please note that in case of In-warranty Lawn Robots, help for software related issues is available only over Phone, Email and Skype.");


        else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "Air Purifiers")
            alert("Please note that in case of In-warranty Air Purifiers, in person demo is available only in four cities i.e.,Bangalore, Delhi/NCR, Pune and Mumbai. In other places we offer demo over Phone, Email and Skype.");
			
        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "Air Purifiers")
            alert("Please note that in case of In-warranty Air Purifiers, in person demo is available only in four cities i.e.,Bangalore, Delhi/NCR, Pune and Mumbai. In other places we offer demo over Phone, Email and Skype.");
        else if (this.value == "Software Issue (Product in Warranty)" && selectedProduct == "Air Purifiers")
            alert("Please note that in case of In-warranty Air Purifiers, help for software related issues is available only over Phone, Email and Skype.");


        else if (this.value == "Demo (Product in Warranty)" && selectedProduct == "Robotic Body Massagers")
            alert("Please note that in case of In-warranty Robotic Body Massagers, demo is available only over Phone, Email and Skype.");
			

        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "Robotic Body Massagers")
            alert("Please note that in case of In-warranty Robotic Body Massagers, installation help is available only over Phone, Email and Skype.");

        else if (this.value == "Installation (Product in Warranty)" && selectedProduct == "TV Mounts and Racks")
            alert("Please note that In-warranty Installation is available only in Delhi NCR at a charge of Rs 750 within a radius of 25km from Gurgaon. At other places we offer installation help over Phone, Email and Skype.");

    });

    function getPurpose(product){
        var category = $('#category');
        category.html('');
        var optionStr = "<option value=''>Select Purpose</option>";
        var existingCustomer = $('input:radio[name=existingCustomer]:checked').val();

        if (product == 'TabTops') {
            if (existingCustomer == "yes") {
                optionStr +=
                    "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                        "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                        "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                        "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                        "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                        "<option value=\"Accessories Query\">Accessories Query</option>  " +
                        "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                        "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";

            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }

        }else if (product == 'Robotic Vacuum Cleaners') {
            if (existingCustomer == "yes") {
                optionStr +=
                    "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                        "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                        "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                        "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                        "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                        "<option value=\"Accessories Query\">Accessories Query</option>  " +
                        "<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                        "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                        "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";
            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }

        } else if (product == "Robotic Window Cleaners") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\">Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
					"<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty) </option>";
            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }
        }else if (product == "Pool Robots") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
					 "<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty)  </option>";
            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }
        }else if (product == "Lawn Robots") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
					 "<option value=\"Warranty Extension\">Warranty Extension</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty) </option>";

            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }
        }else if (product == "Air Purifiers") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Software Issue (Product in Warranty)\" >Software Issue (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  " +
                    "<option value=\"Software Issue (Product – Out of Warranty)\">Software Issue (Product – Out of Warranty)</option>" +
                    "<option value=\"Out  of Warranty Hardware\">Hardware Issue (Product -  Out of Warranty) </option>";

            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Demo\">Pre Sales – Demo</option> " +
                        "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>" ;
            }
        }  else if (product == "Robotic Body Massagers") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Demo (Product in Warranty)\">Demo (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query, body</option>  ";
            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }
        } else if (product == "TV Mounts and Racks") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Usage Related (Product in Warranty)\" >Usage Related (Product in Warranty)</option> " +
                    "<option value=\"Installation (Product in Warranty)\"> Installation (Product in Warranty) </option>" +
                    "<option value=\"Hardware Issue (Product in Warranty)\">Hardware Issue (Product in Warranty) </option>" +
                    "<option value=\"Accessories Query\">Accessories Query</option>  ";

            } else {
                optionStr +=
                    "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }
        } else if (product == "Accessories") {
            if (existingCustomer == "yes") {
                optionStr += "<option value=\"Post Sales – Query\" >Post Sales – Query</option>";
            }else{
                optionStr += "<option value=\"Pre Sales – Query\" >Pre Sales – Query</option>";
            }

        }

        category.append(optionStr);
    }
});