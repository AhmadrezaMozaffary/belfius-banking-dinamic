
// Countdown on Login
// const countdownLogin = (msgPartOne, countdown, msgPartTwo = ".") => {
//   let time = countdown;
//   const loginMessage = alertify.success(
//     `${msgPartOne} ${time} ${msgPartTwo}`,
//     time,
//     () => {
//       clearInterval(countdownFunc);
//     }
//   );
//   const countdownFunc = setInterval(() => {
//     loginMessage.setContent(`${msgPartOne} ${--time} ${msgPartTwo}`);
//   }, 1000);
// };

/**
 * jQuery Code Fore Ajax
 */

$(document).ready(function () {
  // Sign up form AJAX
  $("form#signupForm").submit(function (event) {
    event.preventDefault();
    let form = $(this);
    let url = form.attr("action");
    let dataSerialize = form.serialize();
    dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
    $.ajax({
      type: form.attr("method"),
      url: url,
      data: {
        action: "signup",
        data: dataSerialize,
      },
      dataType: "json",
      success: function (response) {
        if (response["bool"] == false) {
          errorAlert(response["msg"]);
        } else if (response == true) {
          const countdownDuration = 5;
          const emoji = "😎" ? "😎" : ":D";
          countdownLogin(
            `SignUp finished ${emoji} You will see your panel in`,
            countdownDuration,
            " s"
          );
          setTimeout(() => {
            window.location.href = "http://localhost/bank_project/";
          }, countdownDuration * 1000);
        }
      },
    });
  });

  // Login form AJAX
  $("form#loginForm").submit(function (event) {
    event.preventDefault();
    let form = $(this);
    let url = form.attr("action");
    let dataSerialize = form.serialize();
    dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
    $.ajax({
      type: form.attr("method"),
      url: url,
      data: {
        action: "login",
        data: dataSerialize,
      },
      success: function (response) {
        if (response == false) {
          errorAlert("Email or password isn't currect.");
        } else if (response == true) {
          const countdownDuration = 3;
          const emoji = "😎" ? "😎" : ":D";
          countdownLogin(
            `Login finished ${emoji} You will see your panel in`,
            countdownDuration,
            " s"
          );
          setTimeout(() => {
            window.location.href = "http://localhost/bank_project/";
          }, countdownDuration * 1000);
        }
      },
    });
  });

  // Reset password
  $("form#resetPasswordForm").submit(function (event) {
    event.preventDefault();
    let form = $(this);
    let url = form.attr("action");
    let dataSerialize = form.serialize();
    dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
    $.ajax({
      type: form.attr("method"),
      url: url,
      data: {
        action: "resetPassword",
        data: dataSerialize,
      },
      dataType: "json",
      success: function (response) {
        if (response["bool"] == false) {
          errorAlert(response["msg"]);
        } else if (response["bool"] == true) {
          successAlert(response["msg"]);
        }
      },
    });
  });

  // Reset passwrod code
  $("form#resetPasswordCodeForm").submit(function (event) {
    event.preventDefault();
    let form = $(this);
    let url = form.attr("action");
    let dataSerialize = form.serialize();
    dataSerialize = decodeURIComponent(dataSerialize.replace(/%2F/g, " "));
    $.ajax({
      type: form.attr("method"),
      url: url,
      data: {
        action: "resetPasswordCode",
        code: dataSerialize,
      },
      dataType: "json",
      success: function (response) {
        if (response["bool"] == false) {
          errorAlert(response["msg"]);
        } else if (response["bool"] == true) {
          const countdownDuration = 5;
          const emoji = "😎" ? "😎" : ":D";
          countdownLogin(
            `Your password was changed successfully ${emoji} You will see your panel in`,
            countdownDuration,
            "s"
          );
          setTimeout(() => {
            window.location.href = "http://localhost/bank_project/";
          }, countdownDuration * 1000);
        }
      },
    });
  });


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
      dataType: 'json',
      success: function (response) {
        if (response["bool"] == true) {
          alertify.success(response['msg']);
          const amountOfMoney = document.querySelector('#amount-of-money');
          amountOfMoney.textContent = `${response['money']}$`;
          location.reload();
        } else {
          alertify.error(response['msg']);
        }
      }
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
      dataType: 'json',
      success: function (response) {
        // alert(response);
        if (response["bool"] == true) {
          alertify.success(response['msg']);
          const amountOfMoney = document.querySelector('#amount-of-money');
          amountOfMoney.textContent = `${response['money']}$`;
          location.reload();
        } else {
          alertify.error(response['msg']);
        }
      }
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
      dataType: 'json',
      success: function (response) {
        // alert(response);
        console.log(response);
        if (response["bool"] == true) {
          const countdownDuration = 3;
          const emoji = "😎" ? "😎" : ":D";
          countdownLogin(
            `You will logout in`,
            countdownDuration,
            `s ${emoji}`
          );
          // countdownLogin('Ahmad', 3);
          setTimeout(() => {
            window.location.href = "http://localhost/bank_project/";
          }, countdownDuration * 1000);
        } else {
          alertify.error(response['msg']);
        }
      }
    });


  });

});
