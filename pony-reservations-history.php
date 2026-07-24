<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Storico prenotazioni";
$templateParams["nome"] = "template/pony-reservations.php";
$templateParams["js"] = array();
$templateParams["reservations"] = $dbh->get_past_pony_bookings($dbh->get_student_idnumber_from_email($_SESSION['idutente']));
$templateParams["future-reservations"] = false;

require("template/base.php");

?>
