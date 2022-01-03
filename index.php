<?php

use App\Assets;

include "autoload.php";
$assets = new Assets;
if (!isset($_SESSION['userLogin']) || is_null($_SESSION['userLogin'])) {
    header("Location:authentication.php");
}


$movements = $assets->getMovement($_SESSION['userLogin']['id']);

include "views/view_index.php";
