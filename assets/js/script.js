/* #### smooth scrolling and scroll handlers for menu ####*/
jQuery(function($) {
    var scrolling = false;

    function setActive(li) {
        $(li).addClass('active').siblings().removeClass('active');
    }

    $('a.smooth-scroll').click(function(e) {
        setActive($(this).parent('li'));

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                scrolling = true;

                $('html,body').animate({
                    scrollTop: target.offset().top - 70
                }, 400, 'swing', function() {
                    scrolling = false;
                });

                return false;
            }
        }
    });

    $(window).on('scroll', function(e) {
        if (scrolling) {
            return;
        }

        var scrollTop = $(window).scrollTop(),
            closestDistance = Number.MAX_VALUE,
            closestId;

            $('a.smooth-scroll').each(function(i, item) {
                var id = $(this).attr('href').replace(/^#/, ''),
                    offset = $('#' + id).offset();

                if (offset && Math.abs(scrollTop - offset.top) < closestDistance) {
                    closestDistance = Math.abs(scrollTop - offset.top);
                    closestId = id;
                }
            });

        if (closestId) {
            setActive($('.navbar li a[href="#' + closestId + '"]').parent());
        }
    });
});
/* end of smooth scroll */

/* ######back to top java script######### */
jQuery(document).ready(function ($) {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#backToTop').fadeIn('slow');
        } else {
            $('#backToTop').fadeOut('slow');
        }
    });
    $('#backToTop').click(function () {
        $("html, body").animate({scrollTop: 0}, 500);
        return false;
    });
});
/* end of back to top java script */


/*######## function for validating form inputs #######*/
//the pattern will be used in case we match the input with regular expression
function validInput(id, errMsg, minLength, maxLength, errorCheck, pattern, inputType) {

    var inputLength = $(id).val().length;
    if (inputLength <= minLength || inputLength > maxLength) {
        $(errMsg).html("Should be between " + minLength + "-" + maxLength + " characters");
        $(errMsg).show();
        errorCheck = true;
        //if the pattern and inputType is not NULL and the input doesn't match to the given regular expression, then
    } else if ((pattern !== null && inputType !== null) && !pattern.test($(id).val())) {
        if (inputType === "email") {
            $(errMsg).html("Invalid " + inputType + " address!");
        } else if (inputType === "mobile") {
            $(errMsg).html("Invalid " + inputType + " number!");
        } else {
            $(errMsg).html("Invalid " + inputType + "!");
        }
        $(errMsg).show();
        errorCheck = true;
    } else {
        $(errMsg).hide();
    }
}

/*######## function for checking the password confirmation ########*/
function checkPassConfirm(pass, confirm, errMsg, errorCheck) {
    if ($(pass).val() !== $(confirm).val()) {
        $(errMsg).html("Password confirmation doesn't match");
        $(errMsg).show();
        errorCheck = true;
    } else {
        $(errMsg).hide();
    }
}
/* ######## registeration form validation ######### */
$(function () {
    //hiding all the error tooltips initially
    $("#fullname_err_msg").hide();
    $("#email_err_msg").hide();
    $("#mobile_err_msg").hide();
    $("#permenat_address_err_msg").hide();
    $("#current_address_err_msg").hide();
    $("#pass_err_msg").hide();
    $("#confirmpass_err_msg").hide();

    //variables for checking the status of error messages
    var fullname_err_msg = false;
    var email_err_msg = false;
    var mobile_err_msg = false;
    var permenat_address_err_msg = false;
    var current_address_err_msg = false;
    var pass_err_msg = false;
    var passconfirm_err_msg = false;

    //checking the user input when the user moves the cursor out of the input box
    $("#full-name").focusout(function () {
        validInput("#full-name", "#fullname_err_msg", 3, 30, fullname_err_msg, null, "fullname");
    });

    $("#email").focusout(function () {
        validInput("#email", "#email_err_msg", 10, 100, email_err_msg, new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i), "email");
    });

    $("#mobile").focusout(function () {
        validInput("#mobile", "#mobile_err_msg", 10, 20, mobile_err_msg, new RegExp(/^[+a-zA-Z0-9._-]/), "mobile");
    });

    $("#permenant-address").focusout(function () {
        validInput("#permenant-address", "#permenat_address_err_msg", 10, 20, permenat_address_err_msg, null, "address");
    });

    $("#current-address").focusout(function () {
        validInput("#current-address", "#current_address_err_msg", 10, 20, current_address_err_msg,  null, "address");
    });

    $("#password").focusout(function () {
        validInput("#password", "#pass_err_msg", 7, 30, pass_err_msg, null, "password");
    });

    $("#password-confirm").focusout(function () {
        validInput("#password-confirm", "#confirmpass_err_msg", 7, 30, passconfirm_err_msg, null, "confirmation");
        checkPassConfirm("#password", "#password-confirm", "#confirmpass_err_msg", passconfirm_err_msg);
    });


    //when the user clicks on the submit button
    $("#reg-form").submit(function () {
       fullname_err_msg = false;
       email_err_msg = false;
       mobile_err_msg = false;
       permenat_address_err_msg = false;
       current_address_err_msg = false;
       pass_err_msg = false;
       passconfirm_err_msg = false;


        validInput("#full-name", "#fullname_err_msg", 3, 30, fullname_err_msg, null, "fullname");
        validInput("#email", "#email_err_msg", 10, 100, email_err_msg, new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i), "email");
        validInput("#mobile", "#mobile_err_msg", 10, 20, mobile_err_msg, new RegExp(/^[+a-zA-Z0-9._-]/), "mobile");
        validInput("#permenat-address", "#permenat_address_err_msg", 3, 30, permenat_address_err_msg, null, "address");
        validInput("#current-address", "#current_address_err_msg", 3, 30, current_address_err_msg, null, "address");
        validInput("#password", "#pass_err_msg", 7, 30, pass_err_msg, null, "password");
        validInput("#password-confirm", "#confirmpass_err_msg", 7, 30, passconfirm_err_msg, null, "confirmation");
        //checkPassConfirm("#pass", "#pass-confirm", "#confirmpass_err_msg", passconfirm_err_msg);

        if (fullname_err_msg === false && email_err_msg === false && mobile_err_msg === false && permenat_address_err_msg === false && current_address_err_msg === false && pass_err_msg === false && passconfirm_err_msg === false) {
            return true;
        } else {
            return false;
        }
    });
});

/* ####### user login form validation######## */
$(function () {
    $("#username_err_msg").hide();
    $("#loginpass_err_msg").hide();

    var username_err_msg = false;
    var loginpass_err_msg = false;

    $("#username").focusout(function () {
        validInput("#username", "#username_err_msg", 10, 100, username_err_msg, new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i), "email");
    });

    $("#loginpass").focusout(function () {
        validInput("#loginpass", "#loginpass_err_msg", 7, 30, loginpass_err_msg, null, "password");
    });

    $("#login-form").submit(function () {
        username_err_msg = false;
        loginpass_err_msg = false;

        validInput("#username", "#username_err_msg", 10, 100, username_err_msg, new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i), "email");
        validInput("#loginpass", "#loginpass_err_msg", 7, 30, loginpass_err_msg, null, "password");

        if (username_err_msg === false && loginpass_err_msg === false) {
            return true;
        } else {
            return false;
        }
    });
});
/* end of login form validation */
