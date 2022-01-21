"use strict";

//All Elements
const inputUser = document.querySelector(".username");
const inputPass = document.querySelector(".pass");
const firstLoginBtn = document.querySelector(".first-login-btn");
const firstSignupBtn = document.querySelector(".first-signup-btn");
const secondLoginBtn = document.querySelector(".second-login-btn");
const secondSignupBtn = document.querySelector(".second-signup-btn");
const signupSection = document.querySelector(".signup");
const loginPage = document.querySelector(".login-page");
const loginSection = document.querySelector(".login");
const loginHeader = document.querySelector(".login-header");
const loginMessage = document.querySelector(".in-msg");
const backBtn1 = document.querySelector(".back-btn1");
const backBtn2 = document.querySelector(".back-btn2");
const emailInputReset = document.querySelector(
  ".input-content-resetpassword-email"
);
const passInputReset = document.querySelector(
  ".input-content-resetpassword-pass"
);
const showPasswordCheckbox = document.querySelector(".show-password");
const isValidEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

/*
 Showing ALerts
*/
// Showing Error Alerts with Alertify
const errorAlert = (msg) => {
  alertify.error(msg);
};

// Showing Success Alerts with Alertify
const successAlert = (msg) => {
  alertify.success(msg);
};

//Restpassword ( Modal window )
const btnResetPassword = document.querySelector(".btn-reset");

const closeResetPassworModal = document.querySelector(".x-btn");
const modalResetPass = document.querySelector(".modal-reset-pass-container");
const resetPasswordCodeInput = document.querySelector("#resetPasswordCodeForm");

btnResetPassword.addEventListener("click", () => {
  if (inputUser.value && inputUser.value.match(isValidEmail)) {
    emailInputReset.value = inputUser.value;
    modalResetPass.classList.remove("hidden");
  } else {
    inputUser.value = "";
    modalResetPass.classList.remove("hidden");
  }
});

const defaultResetpassForm = () => {
  modalResetPass.classList.add("hidden");
  resetPasswordCodeInput.classList.add("hidden");
  emailInputReset.value = "";
  passInputReset.value = "";
};

closeResetPassworModal.addEventListener("click", () => {
  defaultResetpassForm();
});
document.addEventListener("click", (event) => {
  if (event.target == modalResetPass) {
    defaultResetpassForm();
  }
});
document.addEventListener("keydown", (event) => {
  if (event.key == "Escape") {
    defaultResetpassForm();
  }
});

// Open code submit form

const submitBtnRestModal = document.querySelector(".btn-open-code-input");
submitBtnRestModal.addEventListener("click", (e) => {
  if (
    emailInputReset.value.match(isValidEmail) &&
    passInputReset.value.length != 0
  ) {
    resetPasswordCodeInput.classList.remove("hidden");
  } else if (
    !emailInputReset.value.match(isValidEmail) &&
    emailInputReset.value.length != 0
  ) {
    e.preventDefault();
    emailInputReset.value = "";
    errorAlert("E-mail is not valid !");
  } else {
    e.preventDefault();
    errorAlert("Please fill out the form ⛔️");
  }
});

const userPanel = document.querySelector(".panel");
const btnContainer = document.querySelector(".btn-container");
const logoutBtn = document.querySelector(".logout-btn");

const inputID = document.querySelector(".input-id");
const transferInputAmount = document.querySelector(".transfer-input-amount");
const transferBtn = document.querySelector(".btn-tools");

const reqLoanError = document.querySelector(".loan-error");
const reqInputAmount = document.querySelector(".req-input-amount");
const requestBtn = document.querySelector(".request");

const userConfirmInput = document.querySelector(".user-confirm");
const passConfirmInput = document.querySelector(".pass-confirm");
const logoutError = document.querySelector(".logout-error");
const confirmBtn = document.querySelector(".confirm-logout");

const movementsContainer = document.querySelector(".left-history");
const usersName = document.querySelector(".user-name");
const totalBalance = document.querySelector(".right-about");
const lableIncome = document.querySelector(".income");
const lableOut = document.querySelector(".out");
const lableInterest = document.querySelector(".interest");
const sortBtn = document.querySelector(".sort-btn");

// Calculate and Display Movements Day
const calcDisplayMovDays = function (date, locale) {
  // Calculate Passed days til now
  const calcPassedDays = (day1, day2) =>
    Math.round(Math.abs(day1 - day2) / (1000 * 60 * 60 * 24));
  const passedDays = calcPassedDays(new Date(), date);
  if (passedDays === 0) return "Today";
  else if (passedDays === 1) return "Yesterday";
  else if (passedDays <= 7) return `${passedDays} days ago`;
  else {
    return Intl.DateTimeFormat(locale).format(date);
  }
};

//Updating UserInterface
const updateUI = function (acc) {
  displayMovements(acc);
  calcDisplayBalance(acc);
  calcDisplaySummary(acc);
};

const displayMsg = function (target, msg, msgColor, shadowColor = "white") {
  target.style.color = msgColor;
  target.style.textShadow = `0 0 2px ${shadowColor}`;
  target.textContent = msg;
};

const backBtns = function () {
  loginHeader.style.animation = "move-down-login-header 1s ease";
  loginSection.classList.add("hidden");
  signupSection.classList.add("hidden");
  btnContainer.classList.remove("hidden");
  loginMessage.textContent = "Log in ";
};
backBtn1.addEventListener("click", backBtns);
backBtn2.addEventListener("click", backBtns);

firstLoginBtn.addEventListener("click", () => {
  loginHeader.style.animation = "fade-in-login-header 1.5s ease";
  btnContainer.classList.toggle("hidden");
  loginSection.classList.toggle("hidden");
});

firstSignupBtn.addEventListener("click", () => {
  loginHeader.style.animation = "fade-in-login-header 1.5s ease";
  btnContainer.classList.toggle("hidden");
  signupSection.classList.toggle("hidden");
  loginMessage.textContent = "Sign up ";
});
showPasswordCheckbox.addEventListener("click", () => {
  if (showPasswordCheckbox.checked) {
    inputPass.setAttribute("type", "text");
  } else {
    inputPass.setAttribute("type", "password");
  }
});

secondSignupBtn.addEventListener("click", (e) => {
  const signupEmailVal = document.querySelector(".signup-email").value;
  if (!signupEmailVal.match(isValidEmail)) {
    e.preventDefault();
    errorAlert("E-mail is not valid !");
  }
});

// let currentAcc, timer;
// secondLoginBtn.addEventListener("click", () => {
//   currentAcc = accounts.find(
//     (acc) => acc.username === inputUser.value.toLowerCase()
//   );

//   if (currentAcc?.pin === Number(inputPass.value)) {
//     inputUser.value = inputPass.value = "";
//     loginPage.classList.add("hidden");
//     userPanel.classList.remove("hidden");
//     usersName.textContent = `${currentAcc.owner.split(" ")[0]} 😊`;

//     //TIMER on login
//     if (timer) clearInterval(timer);
//     timer = logoutTimer();

//     updateUI(currentAcc);
//   } else {
//     inputUser.value = inputPass.value = "";
//     alert("Username or Password is INCORRECT!");
//   }
// });

// transferBtn.addEventListener("click", (e) => {
//   e.preventDefault();
//   const reciverAcc = accounts.find((acc) => acc.username === inputID.value);
//   const amount = Number(transferInputAmount.value);
//   inputID.value = transferInputAmount.value = "";
//   if (
//     amount > 0 &&
//     reciverAcc &&
//     reciverAcc !== currentAcc &&
//     currentAcc.balance >= amount
//   ) {
//     currentAcc.movements.push(-amount);
//     reciverAcc.movements.push(amount);
//     currentAcc.movementsDates.push(new Date().toISOString());
//     reciverAcc.movementsDates.push(new Date().toISOString());
//     updateUI(currentAcc);

//     //RESET timer
//     clearInterval(timer);
//     timer = logoutTimer();
//   } else {
//     alert("Wrong information!");
//   }
// });

// requestBtn.addEventListener("click", (e) => {
//   e.preventDefault();
//   const amount = Math.floor(reqInputAmount.value);
//   // It causes an ERROR - FIXME
//   /* const loanRole = currentAcc.movements.some((mov) => mov >= amount * 0.1); */
//   const checkLoan = function () {
//     if (amount > 0 && loanRole) {
//       const msg = `Requested loan \" ${formattedCurrency(
//         amount,
//         currentAcc.locale,
//         currentAcc.currency
//       )} \" Accepted!`;
//       displayMsg(reqLoanError, msg, "green"); //(4th argument)Default text-shadow is WHITE
//       currentAcc.movements.push(amount);
//       currentAcc.movementsDates.push(new Date().toISOString());
//       updateUI(currentAcc);
//     } else if (!loanRole) {
//       const msg = "Requested loan is grater than 10%!";
//       displayMsg(reqLoanError, msg, "red", "yellow");
//       updateUI(currentAcc);
//     } else if (amount <= 0) {
//       updateUI(currentAcc);
//     }

//     //RESET timer
//     clearInterval(timer);
//     timer = logoutTimer();
//   };
//   setTimeout(checkLoan, 2500);

//   reqInputAmount.value = "";
// });

// logoutBtn.addEventListener("click", (e) => {
//   e.preventDefault();
//   if (
//     userConfirmInput.value.toLowerCase() === currentAcc.username &&
//     Number(passConfirmInput.value) === currentAcc.pin
//   ) {
//     userConfirmInput.value = passConfirmInput.value = "";
//     userPanel.classList.add("hidden");
//     loginPage.classList.remove("hidden");
//     displayMsg(reqLoanError, "Request Loan", "black");
//     displayMsg(logoutError, "Close Account", "black");
//     sortBtn.style.color = "black";
//   } else {
//     displayMsg(logoutError, "Wrong User or Password!", "red");
//   }
// });

// let sorted = false;
// sortBtn.addEventListener("click", (e) => {
//   e.preventDefault();
//   displayMovements(currentAcc, !sorted);
//   sorted = !sorted;
//   if (sorted) {
//     sortBtn.style.color = "green";
//   } else {
//     sortBtn.style.color = "black";
//   }
// });

// let sorted = false;
// sortBtn.addEventListener("click", (e) => {
//   e.preventDefault();
//   displayMovements(currentAcc, !sorted);
//   sorted = !sorted;
//   if (sorted) {
//     sortBtn.style.color = "green";
//   } else {
//     sortBtn.style.color = "black";
//   }
// });
