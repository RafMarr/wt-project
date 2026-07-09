<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

$templateParams["titolo"] = "Account Campus+";
$templateParams["nome"] = "profilo.php";
$profileInfo = $dbh->getProfileInfo($_SESSION["idutente"]);

$templateParams["NomeCompletoUtente"] = $profileInfo["Name"] . " " . $profileInfo["Surname"];
$templateParams["Email"] = $_SESSION["idutente"];

$templateParams["js"] = array("./js/profilo.js", "./js/modal-bs-error.js");

if ($dbh->checkAdmin($_SESSION["idutente"])) {
    $templateParams["admin"] = "admin/profilo-admin-section.php";
    $templateParams["js"][] = "./js/profilo-admin.js";
    $templateParams["utenti"] = $dbh->getAccountsExceptCurrent($_SESSION["idutente"]);
}
else {
    $templateParams["NumeroMatricola"] = $profileInfo["IdNumber"];
}

if (isset($_GET["action"])) {
    if ($dbh->checkAdmin($_SESSION["idutente"])) {
        if ($_GET["action"] === "register-admin") {
            if (isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email-utente"]) && isset($_POST["password-utente"]) && isset($_POST["conferma-password"])) {
                if ($_POST["password-utente"] != $_POST["conferma-password"]) {
                    $templateParams["errore"] = "Errore! Le password non coincidono!";
                } else if ($dbh->checkEmailRegistered($_POST['email-utente'])) {
                $templateParams["errore"] = "Errore! L'Email è già registrata!";
                } else if (strlen($_POST['password-utente']) < 8 || !preg_match("#[0-9]+#", $_POST['password-utente']) || !preg_match("#[A-Z]+#", $_POST['password-utente']) || !preg_match("#[a-z]+#", $_POST['password-utente'])) {
                    $templateParams["errore"] = "Errore! La password deve essere di almeno 8 caratteri, inclusa 1 maiuscola, 1 minuscola e 1 numero!";
                }
                else {
                    $dbh->registerAdmin($_POST["nome"], $_POST["cognome"], $_POST["email-utente"], $_POST["password-utente"]);
                    header("location: account.php");
                    exit();
                }
            }
        }
        else if ($_GET["action"] === "delete-admin") {
            if (isset($_POST["email"])) {
                $dbh->deleteAccount($_POST["email"]);
                header("location: account.php");
                exit();
            }
        }
    }
    if ($_GET["action"] === "logout") {
        logoutUser();
        header("location: preview.php");
        exit();
    }
    else if ($_GET["action"] === "delete") {
        $dbh->deleteAccount($_SESSION["idutente"]);
        logoutUser();
        header("location: preview.php");
        exit();
    }
    else if ($_GET["action"] === "change-password") {

        if (isset($_POST["password-corrente"]) && isset($_POST["password-nuova"]) && isset($_POST["conferma-password"])) {
            if ($_POST["password-nuova"] != $_POST["conferma-password"]) {
                $templateParams["errore"] = "Errore! Le password non coincidono!";
            } else if (!$dbh->checkPasswordRegistered($_POST["password-corrente"], $_SESSION["idutente"])) {
                $templateParams["errore"] = "Errore! La password corrente non coincide con quella inserita!";
            } else if (strlen($_POST['password-nuova']) < 8 || !preg_match("#[0-9]+#", $_POST['password-nuova']) || !preg_match("#[A-Z]+#", $_POST['password-nuova']) || !preg_match("#[a-z]+#", $_POST['password-nuova'])) {
                $templateParams["errore"] = "Errore! La password deve essere di almeno 8 caratteri, inclusa 1 maiuscola, 1 minuscola e 1 numero!";
            }
            else {
                $dbh->changePassword($_POST["password-nuova"], $_SESSION["idutente"]);

                header("location: account.php");
                exit();
            }
        }

        $templateParams["titolo"] = "Modifica Password";
        $templateParams["nome"] = "form-change-password.php";
        $templateParams["js"] = array("./js/change-password.js");
        $templateParams["Email"] = $_SESSION["idutente"];
    }
}



require("template/base.php");

?>