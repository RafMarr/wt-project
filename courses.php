<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Informazioni sui corsi";
$templateParams["nome"] = "corsi.php";
$templateParams["js"] = array();
/* TODO: ricorda di fare una piccola schermata per l'admin dove può scegliere il corso
di laurea di cui vuole vedere le informazioni. Lo studente vede le informazioni del corso
di laurea a cui è iscritto, ma l'admin dovrebbe poter vedere le informazioni di tutti i corsi
di laurea */

if ($dbh->checkAdmin($_SESSION["idutente"])) {
    $templateParams["admin"] = true;
    $templateParams["lista-corsi"] = $dbh->getCoursesLabels();
}
else {
    $templateParams["lista-corsi"] = $dbh->getCoursesLabelsFromEmail($_SESSION["idutente"]);
    $templateParams["degree-type"] = $dbh->getDegreeTypeFromEmail($_SESSION["idutente"])["Type"];
}

require("template/base.php");
?>
