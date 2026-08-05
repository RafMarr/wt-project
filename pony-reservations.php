<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

if ($dbh->checkStudent($_SESSION['idutente'])) {
    $templateParams["titolo"] = "Campus+ - Le mie prenotazioni";
    $templateParams["nome"] = "template/pony-future-reservations.php";
    $templateParams["js"] = array("js/pony-reservations.js", "js/modal-bs-error.js");
    $templateParams["reservations"] = $dbh->get_future_pony_bookings($dbh->get_student_idnumber_from_email($_SESSION['idutente']));
} else if ($dbh->checkAdmin($_SESSION['idutente'])) {
    $templateParams["titolo"] = "Campus+ - Gestione prenotazioni";
    // TODO: implement
    // $templateParams["nome"] = "template/pony-future-reservations.php";
    // $templateParams["js"] = array("js/pony-reservations.js", "js/modal-bs-error.js");
    // $templateParams["reservations"] = $dbh->get_future_pony_bookings($dbh->get_student_idnumber_from_email($_SESSION['idutente']));
}

if (isset($_GET['deletion-successful']) && (($_GET['deletion-successful'] == "true") || ($_GET['deletion-successful'] == "false"))) {
    $templateParams['deletion-successful'] = $_GET['deletion-successful'] == "true" ? true : false;
}

require("template/base.php");

?>
