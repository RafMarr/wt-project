<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if($dbh->checkAdmin($_SESSION['idutente'])) {
    $templateParams["admin"] = "";
}

$templateParams["titolo"] = "Home";


$templateParams["nome"] = "home.php";
require("template/base.php");

?>
