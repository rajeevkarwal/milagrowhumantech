$(document).ready(function () {

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


    $("#warranty").submit(function (e) {
        e.preventDefault();
        var name = $.trim($('#name').val());
        var email = $.trim($('#email').val());
        var mobile = $.trim($('#mobile').val());
        var date = $.trim($('#date').val());
        var product = $.trim($("#product option:selected").val());
        var storeName = $.trim($('#storeName').val());
        var address1 = $.trim($('#address1').val());
        var address2 = $.trim($('#address2').val());
        var city = $.trim($('#city').val());
        var state = $.trim($('#state').val());

        if (!name) {
            alert('Name is required');
            return;
        }

        else if (!email) {
            alert('Email is Required');
            return;
        }
        else if (!isValidEmailAddress(email)) {
            alert('Please enter valid email id');
            return;
        }
        else if (!mobile) {
            alert('Mobile is required');
            return;
        }

        else if (!validatePhone(mobile)) {
            alert('Please enter valid 10 digit mobile number.');
            return;
        }
        else if (!product) {
            alert('Product is Required');
            return;
        }
        else if (!date) {
            alert('Date is Required');
            return;
        }
        else if (!storeName) {
            alert('Store name is Required');
            return;
        } else if (!address1) {
            alert('Address1 is Required');
            return;
        } else if (!address2) {
            alert('Address2 is Required');
            return;
        } else if (!city) {
            alert('City is Required');
            return;
        }
        else if (!state) {
            alert('State is Required');
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