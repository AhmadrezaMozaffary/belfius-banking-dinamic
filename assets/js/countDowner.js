
// Countdown on Login
const countdownLogin = (msgPartOne, countdown, msgPartTwo = ".") => {
    let time = countdown;
    const loginMessage = alertify.success(
        `${msgPartOne} ${time} ${msgPartTwo}`,
        time,
        () => {
            clearInterval(countdownFunc);
        }
    );
    const countdownFunc = setInterval(() => {
        loginMessage.setContent(`${msgPartOne} ${--time} ${msgPartTwo}`);
    }, 1000);
};