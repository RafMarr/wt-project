<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Noleggia un pony";
$templateParams["nome"] = "template/pony.php";
$templateParams["js"] = array("js/pony.js");

if (isset($_GET['booking-successful']) && (($_GET['booking-successful'] == "true") || ($_GET['booking-successful'] == "false"))) {
    $templateParams['booking-successful'] = $_GET['booking-successful'] == "true" ? true : false;
}

require("template/base.php");

?>
