$(document).ready(function () {

    $(function () {
        $('#date').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0
        });
        $('#time').timepicker({
            hourMin:9,
            hourMax:18,
            timeFormat: 'HH:mm:ss',
            showSecond: false
        });
    });
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }

    function validatePhone(txtPhone) {

        var filter = /^\d{10}$/;
        return filter.test(txtPhone);

    }

    function validateInt(data) {
        var filter = /^[0-9]+$/;
        return filter.test(data);
    }

	//error show on the bottom of form
    $("#demo").submit(function (e) {
        e.preventDefault();
        var name = $.trim($('#name').val());
        var email = $.trim($('#email').val());
        var mobile = $.trim($('#mobile').val());
        var zip = $.trim($('#zip').val());
        var address = $.trim($('#address').val());
        var date = $.trim($('#date').val());
        var time = $.trim($('#time').val());
        var mode = $.trim($('#demoMode').val());
        var product = $.trim($("#product option:selected").val());
        var city = $.trim($("#city option:selected").val());

        if (!name) {
            var text='Name Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }

        else if (!email) {

            var text='Email is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!isValidEmailAddress(email)) {
            var text='Please enter valid email id';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!mobile) {
            var text='Mobile Number is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }

        else if (!validatePhone(mobile)) {
            var text='Please enter 10 Digit Mobile No.';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!product) {
            var text='Please Select Product';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if(!mode)
        {
            var text='Demo Mode is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!city) {
            var text='City for Demo is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!address) {
            var text='Address for Demo is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!zip) {
            var text='Zip Code for Demo is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!date) {

            var text='Date is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }
        else if (!time) {
            var text='Expected Time is Required';
            $('#Error').html(text);
            $('#Error').show();
            return;
        }


        $('#ajax-loader').show();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (data) {
                $('#ajax-loader').hide();
                if (data.status == false) {
                    alert(data.message);
                }
                else {
                    window.location.href = data.url;
                }
            },
            dataType: 'json'
        });
    });

});