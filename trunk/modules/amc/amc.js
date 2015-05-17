$(document).ready(function () {

    $(function () {
        $('#date').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate:0
//            minDate: 0
        });
//        $('#time').timepicker({
//            hourMin:9,
//            hourMax:18,
//            timeFormat: 'HH:mm:ss',
//            showSecond: false
//        });
    });
    function isValidEmailAddress(emailAddress) {
        //var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        var pattern = new RegExp(/^(?:\w+[\.])*\w+@(?:\w+[\.])*\w+\.\w+$/);
        return pattern.test(emailAddress);
    }

    function validatePhone(txtPhone) {

//        var filter = /^\d{10}$/;
        var filter = /^[0-9]\d{9}$/;
        return filter.test(txtPhone);

    }

    function validateName(txtname){
        var filter = /^([a-zA-Z]+\s)*[a-zA-Z]+$/;
        return filter.test(txtname);
    }

    function validateInt(data) {
        var filter = /^[0-9]+$/;
        return filter.test(data);
    }

    $('#name').blur(function(){
        var name = $.trim($('#name').val());
        if (!name) {
            alert('Name is required');
        }else if(!validateName(name)){
            alert('Please enter valid name');
        }

    });

    $('#email').blur(function(){
        var email = $.trim($('#email').val());
        if (!email) {
            alert('Email is Required');
        }
        else if (!isValidEmailAddress(email)) {
            alert('Please enter valid email id');
        }

    });

    $('#mobile').blur(function(){
        var mobile = $.trim($('#mobile').val());
        if (!mobile) {
            alert('Mobile is required');
        }
        else if (!validatePhone(mobile)) {
            alert('Please enter valid 10 digit mobile number.');
        }

    });


//    $("#amc").submit(function (e) {
//        e.preventDefault();
//        var name = $.trim($('#name').val());
//        var email = $.trim($('#email').val());
//        var mobile = $.trim($('#mobile').val());
//        var zip = $.trim($('#pincode').val());
//        var address = $.trim($('#address').val());
//        var date = $.trim($('#date').val());
////        var time = $.trim($('#time').val());
//        var product = $.trim($("#product option:selected").val());
////        var country = $.trim($("#country option:selected").val());
//        var state = $.trim($("#state option:selected").val());
//        var city = $.trim($("#city").val());
//        var attch_file = $.trim($("#fileUpload").val());
//
//        if (!name) {
//            alert('Name is required');
//            return false;
//        }else if(!validateName(name)){
//            alert('Please enter valid name');
//            return false;
//        }
//
//        else if (!email) {
//            alert('Email is Required');
//            return false;
//        }
//        else if (!isValidEmailAddress(email)) {
//            alert('Please enter valid email id');
//            return false;
//        }
//        else if (!mobile) {
//            alert('Mobile is required');
//            return false;
//        }
//        else if (!validatePhone(mobile)) {
//            alert('Please enter valid 10 digit mobile number.');
//            return false;
//        }
//        else if (!product) {
//            alert('Product is Required');
//            return false;
//        }
//        else if (!address) {
//            alert('Address is Required');
//            return false;
//        }
//        else if (!zip) {
//            alert('Zip code is Required');
//            return false;
//        }
//        else if (!date) {
//            alert('Date is Required');
//            return false;
//        }
//        else if (!time) {
//            alert('Time is Required');
//            return;
//        }
//        else if (!country) {
//            alert('Country is Required');
//            return;
//        }
//        else if (!state) {
//            alert('state is Required');
//            return false;
//        }
//        else if (!city) {
//            alert('City is Required');
//            return false;
//        }
//        else if (!attch_file) {
//            alert('Please Attach Purchase Invoice');
//            return false;
//        }
//
//        return true;
//        $('#ajax-loader').show();
//        $.ajax({
//            type: "POST",
//            url: $(this).attr('action'),
//            data: $(this).serialize(),
//            success: function (data) {
//                $('#ajax-loader').hide();
//                if (data.status == false) {
//                    alert(data.message);
//                }
//                else {
//                    window.location.href = data.url;
//                }
//            },
//            error:function(e){
//              console.log("error" + e.message);
//            },dataType: 'json'
//        });
//    });

});