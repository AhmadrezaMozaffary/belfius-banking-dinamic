<?php

use App\Auth;

include "../autoload.php";
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
}
