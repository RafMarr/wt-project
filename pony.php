<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

if ($dbh->checkStudent($_SESSION['idutente'])) {
    $templateParams["titolo"] = "Campus+ - Noleggia un pony";
    $templateParams["nome"] = "template/pony.php";
    $templateParams["js"] = array("js/pony.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js", "js/modal-bs-error.js");

    if (isset($_GET['booking-successful']) && (($_GET['booking-successful'] === "true") || ($_GET['booking-successful'] === "false"))) {
        $templateParams['booking-successful'] = $_GET['booking-successful'] === "true" ? true : false;
    }
} else if ($dbh->checkAdmin($_SESSION['idutente'])) {
    $templateParams["titolo"] = "Campus+ - Gestione pony";
    $templateParams["nome"] = "template/admin/pony.php";
    $templateParams["js"] = array("js/pony-admin.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js", "js/modal-bs-error.js");

    if (isset($_GET['operation-successful']) && (($_GET['operation-successful'] === "true") || ($_GET['operation-successful'] === "false"))) {
        $templateParams['operation-successful'] = $_GET['operation-successful'] === "true" ? true : false;
    }
}

require("template/base.php");

?>
