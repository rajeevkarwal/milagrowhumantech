/**
 * Created by hitanshu on 25/11/13.
 */


function showRegisterPopup() {
    $.ajax(
        {
            type: 'POST',
            url: baseDir + 'modules/register_popup/register_popup_ajax.php',
            data: {'action': 'showRegisterPopup'},
            dataType: 'json',
            success: function (data) {
                $.fancybox({
                    padding: 0,
                    margin: 0,
                    titleShow: false,
                    autoDimensions: true,
                    overlayShow: true,
                    //                    overlayOpacity : data.login_popup_options.opacity,
//                    overlayColor : data.login_popup_options.overlay_color,
//
//                    showCloseButton: data.login_popup_options.close_button,
                    content: data.html
                });
                //$('#RegisterPopupEmail').focus();
                $.fancybox.resize();
            }
        });
}

function submitRegister() {
	 var fname = $('#RegisterPopupFirstname').val();
	 var lname = $('#RegisterPopupLastname').val();
    var email = $('#RegisterPopupEmail').val();
    var passwd = $('#RegisterPopupPasswd').val();
    var errors = [];
    var field_to_focus = false;
	var fname_error = false
	var lname_error = false
    var email_error = false
    $('#RegisterPopupError').empty();
	
	
	
	if (!fname) {
        errors.push(register_popup_errors.empty_fname);
        fname_error = true;
		
    } 
    
    if (fname_error) {
        field_to_focus = '#RegisterPopupFirstname';
		
    }
	
	if (!lname) {
        errors.push(register_popup_errors.empty_lname);
        lname_error = true;
		
    } 
    
    if (lname_error) {
        field_to_focus = '#RegisterPopupLastname';
		 
    }
	
	
	if (!email) {
        errors.push(register_popup_errors.empty_email);
        email_error = true;
    } else if (!validateEmail(email)) {
        errors.push(register_popup_errors.invalid_email);
        email_error = true;
    }
    if (email_error) {
        field_to_focus = '#RegisterPopupEmail';
    }
	
	
    
    if (!email_error) {
        var passwd_error = false;
        if (!passwd) {
            errors.push(register_popup_errors.empty_passwd);
            passwd_error = true;
        } else if (passwd.length > 32) {
            errors.push(register_popup_errors.long_passwd);
            passwd_error = true;
        } else if (!validatePasswd(passwd)) {
            errors.push(register_popup_errors.invalid_passwd);
            passwd_error = true;
        }
        if (passwd_error && !field_to_focus) {
            field_to_focus = '#RegisterPopupPasswd';
        }
    }
    if (field_to_focus) {
        $(field_to_focus).focus();
    }
    if (errors) {
        for (i in errors) {
            var error = '<div>' + errors[i] + '</div>';
            $('#RegisterPopupError').append(error);
        }
    }
    if (!errors.length) {
        $.ajax(
            {
                type: 'POST',
                url: baseDir + 'modules/register_popup/register_popup_ajax.php',
                data: {'action': 'submitRegister', 'email': email, 'passwd': passwd},
                dataType: 'json',
                success: function (data) {
                    if (!data.hasError) {
                        window.location.href = document.URL;
                    } else {
                        for (i in data.errors) {
                            if (register_popup_errors[data.errors[i]]) {
                                var error = '<div>' + Register_popup_errors[data.errors[i]] + '</div>';
                                $('#RegisterPopupError').append(error);
                            }
                        }
                    }
                }
            });
    }
}





function validateEmail(email) {
    var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(email);
}

function validatePasswd(passwd) {
    var regex = /^[a-zA-Z_\d\-!@#$%\\^&*()]{5,32}$/;
    return regex.test(passwd);
}