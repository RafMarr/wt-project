<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Le mie prenotazioni";
$templateParams["nome"] = "template/pony-reservations.php";
$templateParams["js"] = array("js/pony-reservations.js");
$templateParams["reservations"] = $dbh->get_future_pony_bookings($dbh->get_student_idnumber_from_email($_SESSION['idutente']));
$templateParams["future-reservations"] = true;

if (isset($_GET['deletion-successful']) && (($_GET['deletion-successful'] == "true") || ($_GET['deletion-successful'] == "false"))) {
    $templateParams['deletion-successful'] = $_GET['deletion-successful'] == "true" ? true : false;
}

require("template/base.php");

?>
