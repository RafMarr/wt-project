<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if ($dbh->checkAdmin($_SESSION["idutente"])) {
    $templateParams["admin"] = "admin/segnalazioni-admin.php";
}

if (isset($_GET["action"])) {
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
    else if ($dbh->checkAdmin($_SESSION["idutente"]) && $_GET["action"] === "report-admin") {
        $templateParams["nome"] = $templateParams["admin"];
        $templateParams["titolo"] = "Gestisci Segnalazioni";
        $templateParams["reports"] = $dbh->getReports();

        //$templateParams["js"] = array();
    }
    else {
        header("location: report.php");
        exit();
    }
}
else {
    $templateParams["titolo"] = "Segnalazioni";
    $templateParams["nome"] = "segnalazioni.php";

    $templateParams["reports"] = $dbh->getReports();
}

require("template/base.php");
?>