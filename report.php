<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

$templateParams["titolo"] = "Segnalazioni";
$templateParams["nome"] = "segnalazioni.php";
$templateParams["reports"] = $dbh->getReports();

if ($dbh->checkAdmin($_SESSION["idutente"])) {
    if (isset($_GET["action"])) {
        header("location: report.php");
        exit();
    }
    $templateParams["nome"] = "admin/segnalazioni-admin.php";
    $templateParams["titolo"] = "Gestisci Segnalazioni";
    $templateParams["states"] = array("Non risolto", "Presa in carico", "Risolto");
    $templateParams["js"] = array("./js/segnalazioni-admin.js", "./js/modal-bs-error.js");
}
else if (isset($_GET["action"])) {
    if ($_GET["action"] === "send-report") {

        if (isset($_POST["tipo-segnalazione"]) && isset($_POST["type-select"]) && isset($_POST["place-select"]) && isset($_POST["descrizione-segnalazione"])) {

            // if (!validateReport())

            $dbh->addReport($_POST["tipo-segnalazione"], $_POST["type-select"], $_POST["place-select"], $_POST["descrizione-segnalazione"], $dbh->getStudentID($_SESSION["idutente"])["IdNumber"]);
            header("location: report.php");
            exit();
        }

        $templateParams["titolo"] = "Fai una Segnalazione";
        $templateParams["nome"] = "form-fai-segnalazione.php";
        $templateParams["placeTypes"] = $dbh->getPlaceTypes();
        $templateParams["floors"] = $dbh->getFloors();
        $templateParams["blocks"] = $dbh->getBlocks();

        $templateParams["js"] = array("./js/form-report.js");
    }
    else {
        header("location: report.php");
        exit();
    }
}

require("template/base.php");
?>