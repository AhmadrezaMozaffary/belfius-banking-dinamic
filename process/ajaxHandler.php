<?php

use App\Assets;
use App\Auth;

include "../autoload.php";

function getUserId()
{
    if (isset($_SESSION['userLogin'])) {
        return $_SESSION['userLogin']['id'];
    }
}

function getCurrentUser(string $email = null): ?array
{
    $user = new Assets;
    if (is_null($email)) {
        $user = $user->getUserByEmail($_SESSION['userLogin']['email']);
    } else {
        $user = $user->getUserByEmail($email);
    }
    return $user;
}


if (isset($_POST['action'])) {

    if ($_POST['action'] == "signup") {
        $exploade = (explode('&', $_POST['data']));
        $userData = [
            'email' => explode("=", $exploade[0])[1],
            'fullname' => explode("=", $exploade[1])[1],
            'password' => explode("=", $exploade[2])[1],
            'resetPassword' => explode("=", $exploade[3])[1],
            'currencies' => explode("=", $exploade[4])[1],
        ];
        $auth = new Auth;
        if ($auth->signup($userData)['bool']) {
            echo $auth->login($userData);
        } else {
            echo json_encode($auth->signup($userData));
        }
    }

    if ($_POST['action'] == "login") {
        $exploade = (explode('&', $_POST['data']));
        $userData = [
            'email' => explode("=", $exploade[0])[1],
            'password' => explode("=", $exploade[1])[1],
        ];
        $login = new Auth;
        echo $login->login($userData);
    }

    $resetPassword = new Auth;
    if ($_POST['action'] == "resetPassword") {
        $exploade = (explode('&', $_POST['data']));
        $_SESSION['userData'] = [
            'email' => explode("=", $exploade[0])[1],
            'password' => explode("=", $exploade[1])[1],
        ];
        $resetPassword = new Auth;
        if ($resetPassword->isExistEmail($_SESSION['userData']['email'])) {
            $currentUser = getCurrentUser($_SESSION['userData']['email']);
            if (password_verify($_SESSION['userData']['password'], $currentUser['password'])) {
                // the same key means : the new password equals to the older password and user will log in
                $_SESSION['userLogin'] = $resetPassword->getUserByEmail($_SESSION['userData']['email']);
                echo json_encode(
                    [
                        'msg' => "Your new password equals to your older passwrod and you'll log  in",
                        'same' => true
                    ]
                );
            } else {
                if ($resetPassword->isSafePass($_SESSION['userData']['password'])) {
                    $_SESSION['resetPasswordCode'] = $resetPassword->sendEmail($_SESSION['userData']['email']);
                    if (isset($_SESSION['resetPasswordCode'])) {
                        echo json_encode(
                            [
                                'msg' => "We send a 6-Digits code to your email, please check spam box :D",
                                'bool' => true
                            ]
                        );
                    }
                } else {
                    echo json_encode(
                        [
                            'msg' => "Your new Password isn't safe, your passwrod must be contain 8-Digits, uppercase, lowercase, numbers",
                            'bool' => false
                        ]
                    );
                }
            }
        } else {
            echo json_encode(['msg' => "There isn't this email , Please try again!", 'bool' => false]);
        }
    }

    # Check reset passwrod code
    if ($_POST['action'] == 'resetPasswordCode') {
        $code = explode('=', $_POST['code'])[1];
        if ($code == $_SESSION['resetPasswordCode']) {
            if ($resetPassword->updatePassword($_SESSION['userData']['email'], $_SESSION['userData']['password'])) {
                $auth = new Auth();
                $_SESSION['userLogin'] = $auth->getUserByEmail($_SESSION['userData']['email']);
                echo json_encode(['msg' => "Your password changed :D", 'bool' => true]);
            }
        } else {
            echo json_encode(['msg' => "The code isn't correct , Please try again!", 'bool' => false]);
        }
    }


    # Transfer money
    if ($_POST['action'] == "transferMoney") :
        $exploade = (explode('&', $_POST['data']));
        $userData = [
            'idCard' => explode("=", $exploade[0])[1],
            'amount' => explode("=", $exploade[1])[1],
        ];
        if ($userData['amount'] < 1) {
            echo json_encode(['bool' => false, 'msg' => 'You can not transfer money less than 1 dollar :D']);
        } else {
            if ($userData['idCard'] == $_SESSION['userLogin']['idCard']) {
                echo json_encode(['bool' => false, 'msg' => 'You can not transfer money for yourself :D']);
            } else {
                if (getCurrentUser()['money'] - 10 < $userData['amount']) {
                    $lessOfAmount = $userData['amount'] - (getCurrentUser()['money'] - 10);
                    echo json_encode(['bool' => false, 'msg' => "Your money is not enough, unfortunately you have {$lessOfAmount}$ less:("]);
                } else {
                    $assets = new Assets;
                    $isExistIdCard = $assets->isExistIdCard($userData['idCard']);
                    if ($isExistIdCard != false) {
                        if ($assets->transferMoney(getUserId(), $userData['idCard'], $userData['amount'])) {
                            $senderMovement = $assets->getMovementByID($assets->addMovement(getUserId(), $userData['amount'], intval(0)));
                            $receiverMovement = $assets->addMovement($isExistIdCard->id, $userData['amount'], intval(1));
                            echo json_encode([
                                'money' => getCurrentUser()['money'], 'bool' => true,
                                'msg' => "The money was transferred to {$isExistIdCard->fullname}'s account.",
                                'amountMovement' => $senderMovement->movement,
                                'statusMovement' => $senderMovement->status,
                                'dateMovement'   => $senderMovement->created_at
                            ]);
                        }
                    } else {
                        echo json_encode(['bool' => false, 'msg' => "This ID card isn't exist!"]);
                    }
                }
            }
        }



    endif;


    # Loan request
    if ($_POST['action'] == "loanRequest") {
        $money = explode('=', $_POST['data'])[1];
        $assets = new Assets;
        if ($money < 1) {
            echo json_encode(['bool' => false, 'msg' => "You can not borrow less than one dollar!"]);
        } else {
            if ($assets->loanRequest(getUserId(), $money)) {
                $currentMovement = $assets->getMovementByID($assets->addMovement(getUserId(), $money, intval(1)));
                echo json_encode([
                    'bool' => true,
                    'msg'  => 'Your request has been approved :D',
                    'money' => getCurrentUser()['money'],
                    'amountMovement' => $currentMovement->movement,
                    'statusMovement' => $currentMovement->status,
                    'dateMovement' => $currentMovement->created_at,
                ]);
            } else {
                echo json_encode(['bool' => false, 'msg' => "You can't have this loan, Your movements isn't enough!"]);
            }
        }
    }

    // Logout request
    if ($_POST['action'] == "confirmLogout") {
        $exploade = (explode('&', $_POST['data']));
        $userData = (object)[
            'email' => explode("=", $exploade[0])[1],
            'pass' => explode("=", $exploade[1])[1],
        ];
        $authentication = new Auth;
        $currentUser = (object) getCurrentUser();
        if ($userData->email == $currentUser->email) {
            if (password_verify($userData->pass, $currentUser->password)) {
                $authentication->lougout();
                echo json_encode(['bool' => true]);
            } else {
                echo json_encode(['bool' => false, 'msg' => "Your Password isn't currect!"]);
            }
        } else {
            echo json_encode(['bool' => false, 'msg' => "Your email isn't currect!"]);
        }
    }

    // auto logout based on ajax request
    if ($_POST['action'] == 'autoLogout') {
        $authentication = new Auth;
        if ($_POST['data']) {
            $authentication->lougout();
            echo json_encode([
                'msg' => "You'll logout in",
                'bool' => true
            ]);
        }
    }
}
