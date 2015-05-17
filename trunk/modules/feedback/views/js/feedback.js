$(document).ready(function () {
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }

    $('.slide-out-div').tabSlideOut({
        tabHandle: '.handle',                     //class of the element that will become your tab
//        pathToTabImage: 'modules/feedback/views/img/feedback.png', //path to the image for the tab //Optionally can be set using css
//        imageHeight: '122px',                     //height of tab image           //Optionally can be set using css
//        imageWidth: '40px',                       //width of tab image            //Optionally can be set using css
        tabLocation: 'right',                      //side of screen where tab lives, top, right, bottom, or left
        speed: 300,                               //speed of animation
        action: 'click',                          //options: 'click' or 'hover', action to trigger animation
        topPos: '220px',                          //position from the top/ use if tabLocation is left or right
        leftPos: '20px',                          //position from left/ use if tabLocation is bottom or top
        fixedPosition: true                      //options: true makes it stick(fixed position) on scroll
    });


    $("#feedbackCategory").on('change', function () {
        var category = $.trim($("#feedbackCategory option:selected").val());
        if (category == 4) {
            $('#experienceRadio').show();
        }
        else {
            $('#experienceRadio').hide();
        }
    });

    $("#feedbackForm").submit(function (e) {
        e.preventDefault();
        var email = $.trim($('#feedback-email').val());
        var mobile = $.trim($('#feedback-mobile').val());
        var message = $.trim($('#feedback-message').val());
        var category = $.trim($("#feedbackCategory option:selected").val());
        var experience = $.trim($("#feedbackForm input[type='radio']:checked").val());


        if (!email) {
            $("#feedback_email_error").addClass('feedback-error').html("Please enter email id");
            return;
        }
        else if (!isValidEmailAddress(email)) {
            $("#feedback_email_error").addClass('feedback-error').html("Please enter valid email id");
            return;
        }

        else if (!message) {
            $("#feedback_message_error").addClass('feedback-error').html("Please enter message");
            return;
        }

        else if (!category) {
            $("#feedback_category_error").addClass('feedback-error').html("Category is required");
            return;
        }
        else if (category == 4 && !experience) {
            $("#feedback_radio_error").addClass('feedback-error').html("Please rate the shopping experience");
            return;
        }

        $('#feedback-ajax-loader').show();
        $.ajax({
            type: "POST",
            url: 'modules/feedback/handler.php',
            data: {'email': email, 'message': message, 'category': category, 'experience': experience, 'mobile': mobile, 'currentUrl': window.location.pathname},
            success: function (data) {
                $('#feedback-ajax-loader').hide();
                if (data) {
                    $('#feedback-success-message').show();
                    $('#feedbackForm')[0].reset();
                }
            },
            error: function (data) {

            },
            dataType: 'json'
        });
    });

    $("#feedback-email").keypress(function () {
        if ($.trim($("#feedback-email").val()) != "")
            $("#feedback_email_error").removeClass('feedback-error').html("");

    });

    $("#feedback-message").keypress(function () {
        if ($.trim($("#feedback-message").val()) != "")
            $("#feedback_message_error").removeClass('feedback-error').html("");

    });

    $("#feedbackForm input[type='radio']").click(function () {
        $("#feedback_radio_error").removeClass('feedback-error').html("");
    });

});