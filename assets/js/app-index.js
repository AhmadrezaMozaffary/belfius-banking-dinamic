"use strict";

const totalAmount = document.querySelector("#amount-of-money");
const logedinUsername = document.querySelector(".user-name");
const allMovementsValue = document.querySelectorAll(".n-money");
const totalIncome = document.querySelector(".income");
const totalOut = document.querySelector(".out");
const totalIntrest = document.querySelector(".interest");
let timerIsFinished = false;

//Calculate current date and time and add to DOM based on locale
// Get client locale
const clientLocale = navigator.language || "en-US"; // Clien locale || default value
const lableDate = document.querySelector(".date");
setInterval(() => {
  const now = new Date();
  const options = {
    year: "numeric",
    month: "2-digit",
    day: "numeric",
    hour: "numeric",
    minute: "numeric",
    second: "numeric",
  };
  const formattedDate = Intl.DateTimeFormat(clientLocale, options).format(now);
  lableDate.textContent = formattedDate;
}, 1000);

// Save ID card into Clipboard
const idCardEl = document.querySelector(".id-card");
let idCardNumber;

let hasAnimation = false;
const copyID = () => {
  idCardEl.style.animation = hasAnimation ? "none" : "copying .2s ease 5";
  idCardNumber = idCardEl.textContent;
  navigator.clipboard.writeText(idCardNumber.split("-").join(""));
  alertify.success("Copied");
  hasAnimation = !hasAnimation;
};
idCardEl.addEventListener("click", copyID);

function addHyphen(element) {
  let finalVal = element.textContent.match(/.{1,4}/g).join("-");
  element.textContent = finalVal;
}
addHyphen(idCardEl);

// a Timer for loging out
const lableTimer = document.querySelector(".timer");
const logoutTimer = (min) => {
  let time = min * 60; // In SEC (10m)
  const tick = () => {
    const min = String(Math.trunc(time / 60)).padStart(2, 0);
    const sec = String(time % 60).padStart(2, 0);
    if (time === 0) {
      clearInterval(timer);
    }
    time--;
    lableTimer.textContent = `${min} : ${sec}`;
    if (min == "00" && sec == "00") {
      timerIsFinished = true;
    }
  };
  tick();
  const timer = setInterval(tick, 1000);
  return timer;
};
logoutTimer(10);

// Sidebar
const sidebar = document.querySelector(".sidebar-menu");
const openSidebar = document.querySelector(".open-sidebar");
const closeSidebar = document.querySelector(".close-sidebar");

openSidebar.addEventListener("click", () => {
  sidebar.classList.remove("hidden");
});

closeSidebar.addEventListener("click", () => {
  sidebar.classList.add("hidden");
});

document.addEventListener("click", (event) => {
  if (event.target == sidebar) {
    sidebar.classList.add("hidden");
  }
});
document.addEventListener("keydown", (event) => {
  if (event.key == "Escape") {
    sidebar.classList.add("hidden");
  }
});

// Add currency sign based on selected currency on signup page
const addCurrencySign = (targetEl) => {
  targetEl.textContent = `${targetEl.textContent}${logedinUsername.dataset.currency}`;
};
//for total balance
addCurrencySign(totalAmount);
// for all movements
allMovementsValue.forEach((movement) => addCurrencySign(movement));
// for statistics
addCurrencySign(totalIncome);
addCurrencySign(totalOut);
addCurrencySign(totalIntrest);

// Get "summary.pdf" with HTML2PDF.js
window.addEventListener("load", () => {
  document.querySelector(".pdf-btn").addEventListener("click", () => {
    const printElContainer = document.querySelector(".panel");

    const opt = {
      margin: 1,
      filename: "summary.pdf",
      jsPDF: { format: "letter", orientation: "portrait" },
    };

    document.querySelector(".panel-tools").classList.add("hidden");
    document.querySelector(".panel-statistics").classList.add("hidden");
    document.querySelector(".open-sidebar").classList.add("hidden");
    document.querySelector(".left-history").style.width = "100%";

    // New Promise-based usage:
    html2pdf().set(opt).from(printElContainer).save();

    setTimeout(() => {
      document.querySelector(".panel-tools").classList.remove("hidden");
      document.querySelector(".panel-statistics").classList.remove("hidden");
      document.querySelector(".open-sidebar").classList.remove("hidden");
      document.querySelector(".left-history").style.width = "60%";
    }, 1);
  });
});