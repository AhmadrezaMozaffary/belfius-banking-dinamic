$(document).ready(function () {
    // Ajax request for transfering money
    $("form#transferMoney").submit(function (event) {
        event.preventDefault();
        let form = $(this);
        let url = form.attr("action");
        let dataSerialize = form.serialize();
        dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
        $.ajax({
            type: form.attr("method"),
            url: url,
            data: {
                action: "transferMoney",
                data: dataSerialize,
            },
            dataType: "json",
            success: function (response) {
                if (response["bool"] == true) {
                    alertify.success(response["msg"]);
                    const amountOfMoney = document.querySelector("#amount-of-money");
                    amountOfMoney.textContent = `${response["money"]}$`;
                    location.reload();
                } else {
                    alertify.error(response["msg"]);
                }
            },
        });
    });

    // Ajax request for request loan
    $("form#loanRequest").submit(function (event) {
        event.preventDefault();
        let form = $(this);
        let url = form.attr("action");
        let dataSerialize = form.serialize();
        dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
        $.ajax({
            type: form.attr("method"),
            url: url,
            data: {
                action: "loanRequest",
                data: dataSerialize,
            },
            dataType: "json",
            success: function (response) {
                // alert(response);
                if (response["bool"] == true) {
                    alertify.success(response["msg"]);
                    const amountOfMoney = document.querySelector("#amount-of-money");
                    amountOfMoney.textContent = `${response["money"]}$`;
                    location.reload();
                } else {
                    alertify.error(response["msg"]);
                }
            },
        });
    });

    // Logout ajax request to process/ajaxHandelr.php
    $("form#confirmLogout").submit(function (event) {
        event.preventDefault();
        let form = $(this);
        let url = form.attr("action");
        let dataSerialize = form.serialize();
        dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
        $.ajax({
            type: form.attr("method"),
            url: url,
            data: {
                action: "confirmLogout",
                data: dataSerialize,
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response["bool"] == true) {
                    const countdownDuration = 3;
                    const emoji = "😎" ? "😎" : ":D";
                    countdownLogin(`You will logout in`, countdownDuration, `s ${emoji}`);
                    setTimeout(() => {
                        window.location.href = "http://localhost/bank_project/";
                    }, countdownDuration * 1000);
                } else {
                    alertify.error(response["msg"]);
                }
            },
        });
    });

    const checkTimer = setInterval(() => {
        if (timerIsFinished) {
            // AJAX request to logingout automatically after a certain time
            $.ajax({
                type: "POST",
                url: "process/ajaxHandler.php",
                data: {
                    action: 'autoLogout',
                    data: true
                },
                dataType: "json",
                success: function (response) {
                    if (response['bool']) {
                        const countdownDuration = 3;
                        const emoji = "😎" ? "😎" : ":D";
                        countdownLogin(`${response['msg']}`, countdownDuration, `s ${emoji}`);
                        setTimeout(() => {
                            window.location.href = "http://localhost/bank_project/";
                        }, countdownDuration * 1000);
                    }
                }
            });

            clearInterval(checkTimer);
        }
    }, 1000);
});