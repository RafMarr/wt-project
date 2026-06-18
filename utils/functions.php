<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idutente']);
}

function registerLoggedUser($idutente){
    $_SESSION["idutente"] = $idutente;
}

function logoutUser() {
    if (isset($_SESSION["idutente"])) {
        unset($_SESSION["idutente"]);
    }
}

?>