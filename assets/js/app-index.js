"strict mode";

// Get client locale
const clientLocale = navigator.language || "en-US"; // Clien locale || default value

//Calculate current date and time and add to DOM
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
