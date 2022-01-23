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
        } else if (response["same"] == true) {
          $("#resetPasswordCodeForm").addClass("hidden");
          const countdownDuration = 5;
          const emoji = "😎" ? "😎" : ":D";
          countdownLogin(
            `${response["msg"]} ${emoji} in`,
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
});
