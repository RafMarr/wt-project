<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if (isset($_GET["action"])) {
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
else {

    $templateParams["titolo"] = "Account Campus+";
    $templateParams["nome"] = "profilo.php";
    $profileInfo = $dbh->getProfileInfo($_SESSION["idutente"]);

    $templateParams["NomeCompletoUtente"] = $profileInfo["Name"] . " " . $profileInfo["Surname"];
    $templateParams["NumeroMatricola"] = $profileInfo["IdNumber"];
    $templateParams["Email"] = $profileInfo["Email"];

    $templateParams["js"] = array("./js/profilo.js");
}



require("template/base.php");

?>