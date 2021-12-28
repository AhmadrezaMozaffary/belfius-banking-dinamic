/**
 * jQuery Code Fore Ajax
 */

$(document).ready(function () {
    // Sign up form AJAX
    $("form#signupForm").submit(function (event) {
        event.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let dataSerialize = form.serialize();
        dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: {
                action: 'signup',
                data: dataSerialize
            },
            dataType: "json",
            success: function (response) {
                if (response['bool'] == false) {
                    errorAlert(response['msg']);
                } else {
                    successAlert(response['msg']);
                }
            }
        });
    });

    // Login form AJAX
    $("form#loginForm").submit(function (event) {
        event.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let dataSerialize = form.serialize();
        dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
        $.ajax({
            type: form.attr('method'),
            url: url,
            data: {
                action: 'login',
                data: dataSerialize
            },
            // dataType: "json",
            success: function (response) {
                if (response == false) {
                    errorAlert("Email or password isn't currect.");
                } else if (response == true) {
                    window.location.href = "http://localhost/bank_project/";
                }
            }
        });
    });


});
