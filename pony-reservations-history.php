<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

$templateParams["titolo"] = "Storico prenotazioni";
if ($dbh->checkStudent($_SESSION['idutente'])) {
    $templateParams["nome"] = "template/pony-reservations-history.php";
    $templateParams["js"] = array();
    $templateParams["reservations"] = $dbh->get_past_pony_bookings($dbh->get_student_idnumber_from_email($_SESSION['idutente']));
} else if ($dbh->checkAdmin($_SESSION['idutente'])) {
    $templateParams["nome"] = "template/admin/pony-reservations-history.php";
    $templateParams["ponies-names"] = array_column($dbh->getPonies(null, true), "Name");
    $templateParams["js"] = array("js/admin-pony-reservations-history.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js");
    $templateParams["reservations"] = $dbh->admin_get_past_pony_bookings();
}

require("template/base.php");

?>
