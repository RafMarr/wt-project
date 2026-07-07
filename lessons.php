<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if ($dbh->checkAdmin($_SESSION["idutente"])) {
    $templateParams["admin"] = "";
}

$templateParams["titolo"] = "Orario delle Lezioni";

$templateParams["nome"] = "orario-lezioni.php";

$currentDate = date("Y-m-d");
$defaultYear = 1;
$templateParams["lessons"] = $dbh->getLessonsFiltered($currentDate, $defaultYear, $_SESSION["idutente"]);
$templateParams["js"] = array("./js/orario-lezioni.js");

require("template/base.php");
?>