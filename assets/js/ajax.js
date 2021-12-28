/**
 * jQuery Code Fore Ajax
 */

$(document).ready(function () {
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
                alert(response['msg']);
            }
        });
    });
});
