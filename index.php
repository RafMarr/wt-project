<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Home";


$templateParams["nome"] = "home.php";
require("template/base.php");

?>
