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
}
