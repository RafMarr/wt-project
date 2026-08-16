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
        $templateParams['booking-successful'] = $_GET['booking-successful'] === "true";
    }
} else if ($dbh->checkAdmin($_SESSION['idutente'])) {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === "add-pony") {
            $templateParams["titolo"] = "Campus+ - Aggiungi pony";
            $templateParams["nome"] = "template/admin/pony-form.php";
            $templateParams["js"] = array();
            $templateParams["action"] = $_GET['action'];
            $templateParams["description-max-length"] = $dbh->get_ponies_description_max_length();
            $templateParams["special-marks-max-length"] = $dbh->get_ponies_special_marks_max_length();
            $templateParams["breeds"] = $dbh->get_pony_breeds();
        } else if ($_GET['action'] === "edit-pony") {
            if (isset($_GET['pony-id']) && $dbh->is_pony_id_valid($_GET['pony-id'])) {
                $templateParams["titolo"] = "Campus+ - Modifica informazioni pony";
                $templateParams["nome"] = "template/admin/pony-form.php";
                $templateParams["js"] = array();
                $templateParams["action"] = $_GET['action'];
                $templateParams["pony"] = $dbh->get_pony_info($_GET['pony-id'])[0];
                $templateParams["description-max-length"] = $dbh->get_ponies_description_max_length();
                $templateParams["special-marks-max-length"] = $dbh->get_ponies_special_marks_max_length();
                $templateParams["breeds"] = $dbh->get_pony_breeds();
            } else {
                header('location: pony.php');
            }
        }
    } else {
        $templateParams["titolo"] = "Campus+ - Gestione pony";
        $templateParams["nome"] = "template/admin/pony.php";
        $templateParams["js"] = array("js/pony-admin.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js", "js/modal-bs-error.js");
    }

    if (isset($_GET['operation-successful']) && (($_GET['operation-successful'] === "true") || ($_GET['operation-successful'] === "false"))) {
        $templateParams['operation-successful'] = $_GET['operation-successful'] === "true";
    }
}

require("template/base.php");

?>
