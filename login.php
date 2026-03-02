<?php
require_once("bootstrap.php");

if (!isset($_GET['action'])) {
    header("location: preview.php");
    exit();
}
else {
    if ($_GET['action'] == 'login') {
        if (isset($_POST['email-utente']) && isset($_POST['password-utente'])) {
            $login_result = $dbh->checkLogin($_POST['email-utente'], $_POST['password-utente']);
            if (!$login_result) {
                //Login fallito
                $templateParams["errore"] = "Errore! Controllare username o password!";
            }
            else {
                registerLoggedUser($_POST['email-utente']);
                header("location: index.php");
                exit();
            }
        }
        //Qualcosa è andato storto
        //Aggiungere campo email per UX tramite js;
        $templateParams["nome"] = "form-login.php";
        $templateParams["js"] = array("./js/login.js");
    }
    else if ($_GET['action'] == 'register') {
        if (isset($_POST['email-utente']) && isset($_POST['password-utente']) && isset($_POST['conferma-password']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['matricola']) && isset($_POST['corso-laurea'])) {
            if ($_POST['password-utente'] != $_POST['conferma-password']) {
                $templateParams["errore"] = "Errore! Le password non coincidono!";
            } else if ($dbh->checkEmailRegistered($_POST['email-utente'])) {
                $templateParams["errore"] = "Errore! L'Email è già registrata!";
            } else if ($dbh->checkIdNumberRegistered($_POST['matricola'])) {
                $templateParams["errore"] = "Errore! La matricola è già registrata!";
            } else if (strlen($_POST['password-utente']) < 8 || !preg_match("#[0-9]+#", $_POST['password-utente']) || !preg_match("#[A-Z]+#", $_POST['password-utente']) || !preg_match("#[a-z]+#", $_POST['password-utente'])) {
                //https://phppot.com/php/php-password-validation/ per il pattern per preg_match
                $templateParams["errore"] = "Errore! La password deve essere di almeno 8 caratteri, inclusa 1 maiuscola, 1 minuscola e 1 numero!";
            }
            else {
                $dbh->registerUser($_POST['nome'], $_POST['cognome'], $_POST['email-utente'], $_POST['password-utente'], $_POST['matricola'], $_POST['corso-laurea']);
                registerLoggedUser($_POST['email-utente']);
                header("location: index.php");
                exit();
            }
        }
        //-Qualcosa è andato storto
        $templateParams["corsi"] = $dbh->getCourses();
        $templateParams["nome"] = "form-register.php";
        $templateParams["js"] = array("./js/register.js");
    }
}

$templateParams["titolo"] = "Campus+";

$templateParams["no-nav"] = "";

require("template/base.php");
?>