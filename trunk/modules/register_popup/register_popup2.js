/**
 * Created by hitanshu on 25/11/13.
 */
function redirectNewCustomer() {
    var email = $('#RegisterPopupEmail').val();
    var error = false;
    if (!email) {
        error = login_popup_errors.empty_email;
    } else if (!validateEmail(email)) {
        error = login_popup_errors.invalid_email;
    }
    if (error) {
        $('#RegisterPopupError').html(error);
        $('#RegisterPopupEmail').focus();
    } else {
        $.ajax(
            {
                type: 'POST',
                url: baseDir + 'modules/register_popup/register_popup_ajax.php',
                data: {'action': 'checkCustomerEmail', 'email': email},
                dataType: 'json',
                success: function (data) {
                    if (data.hasError) {
                        $('#RegisterPopupError').html(register_popup_errors.account_exists);
                    } else {
                        $('#RegisterPopupEmail').attr('name', 'email_create');
                        $.fancybox.close();
                        $('#RegisterPopupForm').submit();
                    }
                }
            });
    }
}

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
	var fname_error = false;
	var lname_error = false;
    var email_error = false
    $('#RegisterPopupError').empty();
	
	 if (!fname) {
        errors.push(register_popup_errors.empty_fname);
        fname_error = true;
		 field_to_focus = '#RegisterPopupFirstname';
    } 
	
	
   /* if (fname_error) {
        field_to_focus = '#RegisterPopupFirstname';
    }*/
	
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
    } /*else if (!validateEmail(email)) {
        errors.push(register_popup_errors.invalid_email);
        email_error = true;
    }*/
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
                data: {'action': 'submitRegister', 'fname': fname,  'email': email, 'passwd': passwd},
                dataType: 'json',
                success: function (data) {
                    if (!data.hasError) {
                        window.location.href = document.URL;
                    } else {
                        for (i in data.errors) {
                            if (register_popup_errors[data.errors[i]]) {
                                var error = '<div>' + register_popup_errors[data.errors[i]] + '</div>';
                                $('#RegisterPopupError').append(error);
                            }
                        }
                    }
                }
            });
    }
}

function showContactPopup() {
    $.ajax(
        {
            type: 'POST',
            url: baseDir + 'modules/login_popup/login_popup_ajax.php',
            data: {'action': 'showContactPopup'},
            dataType: 'json',
            success: function (data) {
                $.fancybox({
                    padding: 0,
                    margin: 0,
                    titleShow: false,

                    overlayShow: true,
                    overlayOpacity: data.contact_popup_options.opacity,
                    overlayColor: data.contact_popup_options.overlay_color,

                    showCloseButton: data.contact_popup_options.close_button,
                    content: data.html
                });
                $.fancybox.resize();
            }
        });
}

function submitContact() {
    var email = $('#ContactPopupEmail').length ? true : '';
    var name = $('#ContactPopupName').length ? true : '';
    var heading = $('#ContactPopupHeading').length ? $('#ContactPopupHeading').val() : '';
    var subject = $('#ContactPopupSubject').length ? true : '';
    var message = $.trim($('#ContactPopupMessage').val());
    var copy = ($('#ContactPopupCopy').length && $('#ContactPopupCopy').is(':checked')) ? 1 : '';

    var errors = [];
    var field_to_focus = [];
    var email_error = false
    $('#ContactPopupError').empty();
    if (email) {
        email = $('#ContactPopupEmail').val();
        if (!email.length) {
            errors.push(contact_popup_errors.empty_email);
            email_error = true;
        } else if (!validateEmail(email)) {
            errors.push(contact_popup_errors.invalid_email);
            email_error = true;
        }
    }
    if (email_error) {
        field_to_focus.push('#ContactPopupEmail');
    }

    if (name) {
        name = $('#ContactPopupName').val();
        if (!name.length) {
            errors.push(contact_popup_errors.empty_name);
            field_to_focus.push('#ContactPopupName');
        }
    }

    if (heading && heading == 0) {
        errors.push(contact_popup_errors.empty_heading);
    }

    if (subject) {
        subject = $('#ContactPopupSubject').val();
        if (!subject.length) {
            errors.push(contact_popup_errors.empty_subject);
            field_to_focus.push('#ContactPopupSubject');
        }
    }

    if (!message.length) {
        errors.push(contact_popup_errors.empty_message);
        field_to_focus.push('#ContactPopupMessage');
    }

    if (field_to_focus.length) {
        $(field_to_focus.shift()).focus();
    }
    if (errors) {
        for (i in errors) {
            var error = '<div>' + errors[i] + '</div>';
            $('#ContactPopupError').append(error);
        }
    }

    if (!errors.length) {
        $.ajax(
            {
                type: 'POST',
                url: baseDir + 'modules/login_popup/login_popup_ajax.php',
                data: {'action': 'submitContact', 'name': name, 'email': email, 'heading': heading, 'subject': subject, 'copy': copy, 'message': message},
                dataType: 'json',
                success: function (data) {
                    if (!data.hasError) {
                        var success = '<div class="success">' + contact_popup_errors['success'] + '</div>';
                        $('#ContactPopup').append(success);
                        $('#ContactPopupForm').hide();
                        $('#ContactPopupForm')[0].reset();
                    } else {
                        for (i in data.errors) {
                            if (contact_popup_errors[data.errors[i]]) {
                                var error = '<div>' + contact_popup_errors[data.errors[i]] + '</div>';
                                $('#ContactPopupError').append(error);
                            }
                        }
                    }
                    $.fancybox.resize();
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