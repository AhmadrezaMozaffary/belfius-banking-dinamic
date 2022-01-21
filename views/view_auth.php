<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Belfius Banking</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- LOGIN Page -->
    <section class="login-page">
        <section class="login-form">
            <header class="login-header">
                <a href="#">
                    <img src="assets/images/bank-logo.png" alt="" />
                </a>
                <h2 class="login-msg primary-h2">
                    <span class="in-msg">Log in </span>to get started
                </h2>
            </header>
            <section class="btn-container">
                <button class="btn btn-primary first-login-btn">Login</button>
                <button class="btn btn-secondary first-signup-btn">SignUp</button>
            </section>
            <!-- LOGIN -->
            <section class="login hidden">

                <form id="loginForm" action="process/ajaxHandler.php" method="POST">
                    <input type="Email" name="email" placeholder="Email" class="username" required />
                    <input type="password" name="password" placeholder="password" class="pass" required />
                    <div class="showpassword-container">
                        <label for="showpassword" style="opacity: 0.7;">Show Password</label>
                        <input type="checkbox" name="showpassword" class="show-password">
                    </div>
                    <button class="btn-reset" type="button">Forgot password?</button>
                    <section class="btn-container">
                        <input type="submit" class="btn btn-primary second-login-btn" value="Login" style="width: 50%;">
                        <input class="btn btn-secondary back-btn1 back-btn-input" value="BACK">
                    </section>
                </form>

            </section>
            <!-- SIGN UP -->
            <section class="signup hidden">
                <form id="signupForm" action="process/ajaxHandler.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="text" name="fullname" placeholder="Full name" required />
                    <input type="password" name="password" placeholder="Password" required />
                    <input type="password" name="resetPassword" placeholder="Confirm password" required />
                    <div class="selection-menu">
                        <select name="currencies" id="currencies">
                            <option value="null">Currency</option>
                            <?php foreach (CURRENCY_CONFIG as $key => $currency) : ?>
                                <option value="<?= $key ?>"><?= CURRENCY_CONFIG[$key] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Get client locale (language) -->
                    <input type="text" name="locale" value="en-US" class="client-locale">
                    <section class="btn-container">
                        <input type="submit" class="btn btn-primary second-signup-btn" value="SignUp" style="width: 50%; border-radius: none;">
                        <input class="btn btn-secondary back-btn2 back-btn-input" value="BACK">
                    </section>
                </form>
            </section>
        </section>
        <!-- Modal Rest Password -->
        <section class="modal-reset-pass-container hidden">
            <section class="modal-reset-pass">
                <button class="x-btn">
                    x
                </button>
                <form id="resetPasswordForm" action="process/ajaxHandler.php" method="POST">
                    <input class="input-content-resetpassword-email" name="email" type="email" placeholder="Email" required>
                    <input class="input-content-resetpassword-pass" name="password" type="password" placeholder="New password" required>
                    <input type="submit" class="btn btn-primary btn-open-code-input">
                </form>
                <div class="seprater-line"></div>
                <form id="resetPasswordCodeForm" action="process/ajaxHandler.php" method="POST" class="hidden">
                    <input type="number" min="100000" max="999999" name="code" class="code-reset-password" placeholder="code" required>
                    <input type="submit" class="btn btn-primary" value="Change my password" required>
                </form>
            </section>
        </section>
    </section>

    <!-- Alertify Library -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- Main JS -->
    <script src="assets/js/countDowner.js"></script>
    <script src="assets/js/app.js"></script>
    <!-- AJAX Handler -->
    <script src="assets/js/ajax.js"></script>

</body>

</html>