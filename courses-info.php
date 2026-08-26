<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
}

$templateParams["titolo"] = "Campus+ - Informazioni sui corsi";
$templateParams["nome"] = "template/courses-info.php";
$templateParams["js"] = array();
/* TODO: ricorda di fare una piccola schermata per l'admin dove può scegliere il corso
di laurea di cui vuole vedere le informazioni. Lo studente vede le informazioni del corso
di laurea a cui è iscritto, ma l'admin dovrebbe poter vedere le informazioni di tutti i corsi
di laurea */

require("template/base.php");
?>
