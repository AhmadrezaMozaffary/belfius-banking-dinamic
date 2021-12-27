"use strict";

//Elements
const inputUser = document.querySelector(".username");
const inputPass = document.querySelector(".pass");
const firstLoginBtn = document.querySelector(".first-login-btn");
const firstSignupBtn = document.querySelector(".first-signup-btn");
const secondLoginBtn = document.querySelector(".second-login-btn");
const secondSignupBtn = document.querySelector(".second-signup-btn");
const signupSection = document.querySelector(".signup");
const loginPage = document.querySelector(".login-page");
const loginSection = document.querySelector(".login");
const loginHeader = document.querySelector(".loign-header");
const loginMessage = document.querySelector(".in-msg");
const backBtn1 = document.querySelector(".back-btn1");
const backBtn2 = document.querySelector(".back-btn2");

const userPanel = document.querySelector(".panel");
const btnContainer = document.querySelector(".btn-container");
const logoutBtn = document.querySelector(".logout-btn");

const lableDate = document.querySelector(".date");

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

const lableTimer = document.querySelector(".timer");

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

// Formating the Currencies
const formattedCurrency = function (value, locale, currency) {
  return new Intl.NumberFormat(locale, {
    style: "currency",
    currency: currency,
  }).format(value);
};

// Display movements
const displayMovements = function (acc, sort = false) {
  // reset movement's container (parent)
  movementsContainer.innerHTML = "";
  const movs = sort
    ? acc.movements.slice().sort((a, b) => a - b)
    : acc.movements;

  // Is deposit or no ?
  movs.forEach((mov, i) => {
    const type = mov > 0 ? "deposit" : "withdraw";

    //Display movement's date
    const movTime = new Date(acc.movementsDates[i]);
    const displayMovTime = calcDisplayMovDays(movTime, acc.locale);

    const formattedMov = formattedCurrency(mov, acc.locale, acc.currency);

    // Each movement component
    const html = `
      <div class="left-history-content">
          <div class="his-content-left">
            <p>
              <span class="his-num">${i + 1}</span>
              <span class="kind-of-his ${type}">${type}</span>
            </p>
            <p class="his-date">${displayMovTime}</p>
          </div>
          <p class="n-money">${formattedMov}</p>
      </div>
    `;

    // adding movement component to the DOM
    movementsContainer.insertAdjacentHTML("afterbegin", html);
  });
};

// Calculate and Displat balance
const calcDisplayBalance = function (acc) {
  acc.balance = acc.movements.reduce((temp, mov) => (temp += mov), 0);
  totalBalance.textContent = `${formattedCurrency(
    acc.balance,
    acc.locale,
    acc.currency
  )}`;
};

// Calculate and Displat summary
const calcDisplaySummary = function (acc) {

  // Calculate statistics
  const income = acc.movements
    .filter((mov) => mov > 0)
    .reduce((temp, deposit) => (temp += deposit));
  const out = acc.movements
    .filter((mov) => mov < 0)
    .reduce((temp, withdraw) => (temp += withdraw), 0);
  const interest = acc.movements
    .filter((mov) => mov > 0)
    .map((deposit) => (deposit * acc.interestRate) / 100)
    .filter((int) => int >= 1)
    .reduce((temp, int) => (temp += int), 0);
  lableIncome.textContent = `${formattedCurrency(
    income,
    acc.locale,
    acc.currency
  )}`;
  lableOut.textContent = `${formattedCurrency(out, acc.locale, acc.currency)}`;
  lableInterest.textContent = `${formattedCurrency(
    interest,
    acc.locale,
    acc.currency
  )}`;
};

//Updating UserInterface
const updateUI = function (acc) {
  displayMovements(acc);
  calcDisplayBalance(acc);
  calcDisplaySummary(acc);
};

// a Timer for loging out
const logoutTimer = function () {
  let time = 10 * 60; // In SEC (10m)
  const tick = function () {
    const min = String(Math.trunc(time / 60)).padStart(2, 0);
    const sec = String(time % 60).padStart(2, 0);

    if (time === 0) {
      clearInterval(timer);
    }

    time--;

    lableTimer.textContent = `${min} : ${sec}`;
  };

  tick();

  const timer = setInterval(tick, 1000);

  return timer;
};

const displayMsg = function (target, msg, msgColor, shadowColor = "white") {
  target.style.color = msgColor;
  target.style.textShadow = `0 0 2px ${shadowColor}`;
  target.textContent = msg;
};

const backBtns = function () {
  loginSection.classList.add("hidden");
  signupSection.classList.add("hidden");
  btnContainer.classList.remove("hidden");
  loginMessage.textContent = "Log in ";
};
backBtn1.addEventListener("click", backBtns);
backBtn2.addEventListener("click", backBtns);

firstLoginBtn.addEventListener("click", () => {
  btnContainer.classList.toggle("hidden");
  loginSection.classList.toggle("hidden");
});

firstSignupBtn.addEventListener("click", () => {
  btnContainer.classList.toggle("hidden");
  signupSection.classList.toggle("hidden");
  loginMessage.textContent = "Sign up ";
});

let currentAcc, timer;
secondLoginBtn.addEventListener("click", () => {
  currentAcc = accounts.find(
    (acc) => acc.username === inputUser.value.toLowerCase()
  );

  //Calculate current date and time
  const now = new Date();
  const options = {
    year: "numeric",
    month: "2-digit",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
  };
  const formattedDate = Intl.DateTimeFormat(currentAcc.locale, options).format(
    now
  );
  lableDate.textContent = formattedDate;

  if (currentAcc?.pin === Number(inputPass.value)) {
    inputUser.value = inputPass.value = "";
    loginPage.classList.add("hidden");
    userPanel.classList.remove("hidden");
    usersName.textContent = `${currentAcc.owner.split(" ")[0]} 😊`;

    //TIMER on login
    if (timer) clearInterval(timer);
    timer = logoutTimer();

    updateUI(currentAcc);
  } else {
    inputUser.value = inputPass.value = "";
    alert("Username or Password is INCORRECT!");
  }
});

transferBtn.addEventListener("click", (e) => {
  e.preventDefault();
  const reciverAcc = accounts.find((acc) => acc.username === inputID.value);
  const amount = Number(transferInputAmount.value);
  inputID.value = transferInputAmount.value = "";
  if (
    amount > 0 &&
    reciverAcc &&
    reciverAcc !== currentAcc &&
    currentAcc.balance >= amount
  ) {
    currentAcc.movements.push(-amount);
    reciverAcc.movements.push(amount);
    currentAcc.movementsDates.push(new Date().toISOString());
    reciverAcc.movementsDates.push(new Date().toISOString());
    updateUI(currentAcc);

    //RESET timer
    clearInterval(timer);
    timer = logoutTimer();
  } else {
    alert("Wrong information!");
  }
});

requestBtn.addEventListener("click", (e) => {
  e.preventDefault();
  const amount = Math.floor(reqInputAmount.value);
  // It causes an ERROR - FIXME
  /* const loanRole = currentAcc.movements.some((mov) => mov >= amount * 0.1); */
  const checkLoan = function () {
    if (amount > 0 && loanRole) {
      const msg = `Requested loan \" ${formattedCurrency(
        amount,
        currentAcc.locale,
        currentAcc.currency
      )} \" Accepted!`;
      displayMsg(reqLoanError, msg, "green"); //(4th argument)Default text-shadow is WHITE
      currentAcc.movements.push(amount);
      currentAcc.movementsDates.push(new Date().toISOString());
      updateUI(currentAcc);
    } else if (!loanRole) {
      const msg = "Requested loan is grater than 10%!";
      displayMsg(reqLoanError, msg, "red", "yellow");
      updateUI(currentAcc);
    } else if (amount <= 0) {
      updateUI(currentAcc);
    }

    //RESET timer
    clearInterval(timer);
    timer = logoutTimer();
  };
  setTimeout(checkLoan, 2500);

  reqInputAmount.value = "";
});

logoutBtn.addEventListener("click", (e) => {
  e.preventDefault();
  if (
    userConfirmInput.value.toLowerCase() === currentAcc.username &&
    Number(passConfirmInput.value) === currentAcc.pin
  ) {
    userConfirmInput.value = passConfirmInput.value = "";
    userPanel.classList.add("hidden");
    loginPage.classList.remove("hidden");
    displayMsg(reqLoanError, "Request Loan", "black");
    displayMsg(logoutError, "Close Account", "black");
    sortBtn.style.color = "black";
  } else {
    displayMsg(logoutError, "Wrong User or Password!", "red");
  }
});

let sorted = false;
sortBtn.addEventListener("click", (e) => {
  e.preventDefault();
  displayMovements(currentAcc, !sorted);
  sorted = !sorted;
  if (sorted) {
    sortBtn.style.color = "green";
  } else {
    sortBtn.style.color = "black";
  }
});
