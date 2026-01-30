<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idutente']);
}

function registerLoggedUser($idutente){
    $_SESSION["idutente"] = $idutente;
}

?>