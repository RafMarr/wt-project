<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if ($dbh->checkAdmin($_SESSION["idutente"])) {
    $templateParams["admin"] = "";
}

if (isset($_GET["action"])) {
    if ($_GET["action"] === "send-report") {

        if (isset($_POST["tipo-segnalazione"]) && isset($_POST["luogo-segnalazione"]) && isset($_POST["descrizione-segnalazione"])) {

            if ($_POST["luogo-segnalazione"] === "AULA" && isset($_POST["aula-select"])) {
                $placeId = $_POST["aula-select"];
            }
            else if ($_POST["luogo-segnalazione"] === "LAB." && isset($_POST["lab-select"])) {
                $placeId = $_POST["lab-select"];
            }
            else if ($_POST["luogo-segnalazione"] === "Bathroom" && isset($_POST["bagni-select"])) {
                $placeId = $_POST["bagni-select"];
            }
            else if ($_POST["luogo-segnalazione"] === "Corridor" && isset($_POST["piano-segnalazione"]) && isset($_POST["blocco-segnalazione"])) {
                $placeId["piano"] = $_POST["piano-segnalazione"];
                $placeId["blocco"] = $_POST["blocco-segnalazione"];
            }
            else if ($_POST["luogo-segnalazione"] === "Bike-Parking" && isset($_POST["piani-parcheggi"])) {
                $placeId = $_POST["piani-parcheggi"];
            }
            else {
                header("location: report.php");
                exit();
            }

            $dbh->addReport($_POST["tipo-segnalazione"], $_POST["luogo-segnalazione"], $placeId, $_POST["descrizione-segnalazione"], $dbh->getStudentID($_SESSION["idutente"])["IdNumber"]);
            header("location: report.php");
            exit();
        }

        $templateParams["titolo"] = "Fai una Segnalazione";
        $templateParams["nome"] = "form-fai-segnalazione.php";
        $templateParams["blocks"] = array('A', 'B', 'C');
        $templateParams["aulee"] = $dbh->getAulee();
        $templateParams["labs"] = $dbh->getLabs();
        $templateParams["bagni"] = $dbh->getBathrooms();

        $templateParams["js"] = array("./js/form-report.js");
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