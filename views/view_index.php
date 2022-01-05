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
    <meta name="theme-color" content="#fff" />
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- USER Panel -->
    <section class="panel">
        <!-- Panel Navbar -->
        <nav class="panel-nav">
            <div class="panel-inner-nav">
                <div>
                    <h3>Welcome, <span class="user-name"><?= $currentUser['fullname'] ?></span></h3>
                </div>
                <div class="open-sidebar">
                    <div class="sidebar-dots sidebar-dot1"></div>
                    <div class="sidebar-dots sidebar-dot2"></div>
                    <div class="sidebar-dots sidebar-dot3"></div>
                </div>
            </div>
        </nav>

        <!-- Panel Contents -->
        <section class="panel-contents">
            <!-- ABOUT -->
            <section class="panel-about">
                <div class="left-about">
                    <h3>Current Balance</h3>
                    <h5>As of <span class="date">2021/03/07</span></h5>
                    <h5>Your ID card : <abbr title="COPY!" class="id-card"><?= $currentUser['idCard'] ?></abbr></h5>
                </div>
                <h2 class="right-about" id="amount-of-money"><?= $currentUser['money'] ?>$</h2>
            </section>

            <!-- TOOLS -->
            <section class="panel-all-tools">
                <!-- TOOLS > LEFT -->
                <section class="left-history">
                    <!-- HISTORY -->
                    <?php
                    if (!is_null($movements)) {
                        foreach ($movements as $key => $mov) :
                    ?>
                            <div class="left-history-content">
                                <div class="his-content-left">
                                    <p>
                                        <span class="his-num"><?= $key + 1 ?></span>
                                        <span class="his-num"></span><span class="kind-of-his <?= $mov->status ? 'deposit' : 'withdraw' ?>"><?= $mov->status ? 'deposit' : 'withdraw' ?></span>
                                    </p>
                                    <p class="his-date"><?= $mov->created_at ?></p>
                                </div>
                                <p class="n-money"><?= $mov->status ? '+' : '-' ?><?= $mov->movement ?></p>
                            </div>
                    <?php
                        endforeach;
                    }
                    ?>
                </section>
                <!-- TOOLS > RIGHT -->
                <section class="panel-tools">
                    <!-- TRANSFER MONEY -->
                    <section class="tools transfer">
                        <form id="transferMoney" action="process/ajaxHandler.php" method="POST">
                            <label for="transfer">Transfer Money</label>
                            <div>
                                <div>
                                    <input type="number" name="idCard" class="input-tools input-id" min="1000000000000000" max="9999999999999999" placeholder="Destination ID" />
                                </div>
                                <div>
                                    <input type="number" name="amountOfMoney" class="input-tools transfer-input-amount" placeholder="Amount of money" />
                                </div>
                                <input type="submit" class="btn-tools" value="Transfer ✔️">
                            </div>
                        </form>
                    </section>
                    <!-- REQUEST LOAN -->
                    <section class="tools request">
                        <form id="loanRequest" action="process/ajaxHandler.php" method="POST">
                            <label for="transfer" class="loan-error">Request Loan</label>
                            <div>
                                <div>
                                    <input type="number" name="amountOfMoney" class="input-tools req-input-amount" placeholder="Amount" />
                                </div>
                                <input type="submit" class="btn-tools" value="Request ✔️">
                            </div>
                        </form>
                    </section>
                    <!-- CONFIRM LOGOUT -->
                    <section class="tools confirm-logout">
                        <form action="#">
                            <label for="confirm-logout" class="logout-error">Close Account</label>
                            <div>
                                <div>
                                    <input type="text" name="user" class="input-tools user-confirm" placeholder="Confirm User" />
                                </div>
                                <div>
                                    <input type="password" name="pass" class="input-tools pass-confirm" placeholder="Confirm Pass" />
                                </div>
                                <button type="submit" class="btn-tools logout-btn">
                                    Close ✔️
                                </button>
                            </div>
                        </form>
                    </section>
                </section>
            </section>

            <!-- STATISTICS -->
            <section class="panel-statistics">
                <!-- STATISTICS LEFT -->
                <div class="statistics-left">
                    <p>in<span class="sta-amount income"><?= $assets->countOfMovements($_SESSION['userLogin']['id'], 1)  ?>$</span></p>
                    <p>out<span class="sta-amount out"><?= $assets->countOfMovements($_SESSION['userLogin']['id'], 0) ?>$</span></p>
                    <p>all movements<span class="sta-amount interest"><?= $assets->countOfMovements($_SESSION['userLogin']['id']) ?>$</span></p>
                    <button class="btn sort-btn">&darr;sort</button>
                </div>

                <!-- STATISTICS RIGHT -->
                <div class="statistics-right">
                    <p>You will be logged out in <span class="timer">09:44</span></p>
                </div>
            </section>
        </section>
    </section>

    <manu class="sidebar-menu hidden">
        <div class="inner-sidebar-menu">
            <nav class="sidebar-nav">
                <button class="close-sidebar">x</button>
            </nav>
            <section class="sidebar-inner-content">
                <div class="clock">clock</div>
                <div class="toggler">dark/light toggler</div>
                <footer class="sidebar-nav-footer">contents</footer>
            </section>
        </div>
    </manu>

    <!-- Alertify Library -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- Main JS -->
    <script src="assets/js/app-index.js"></script>
    <!-- AJAX Handler -->
    <script src="assets/js/ajax.js"></script>

</body>

</html>