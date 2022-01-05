<?php

use App\Assets;

include "autoload.php";

$assets = new Assets;

if (!isset($_SESSION['userLogin']) || is_null($_SESSION['userLogin'])) {
    header("Location:authentication.php");
}


$movements = $assets->getMovementByUserID($_SESSION['userLogin']['id']);

$currentUser = (new Assets)->getUserByEmail($_SESSION['userLogin']['email']);



include "views/view_index.php";
