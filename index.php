<?php
session_start();

if (!isset($_SESSION['userLogin']) || is_null($_SESSION['userLogin'])) {
    header("Location:authentication.php");
}
include "views/view_index.php";
