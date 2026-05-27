<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Noleggia un pony";
$templateParams["nome"] = "template/pony.php";
$templateParams["js"] = array("js/pony.js");
require("template/base.php");

?>
