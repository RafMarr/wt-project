<?php
require_once("bootstrap.php");

if (!isset($_GET['action'])) {
    header("location: preview.php");
}
else {
    if ($_GET['action'] == 'login')
        $templateParams["nome"] = "form-login.php";
    else
        $templateParams["nome"] = "form-register.php";
}

$templateParams["titolo"] = "Campus+";

$templateParams["no-nav"] = "";

require("template/base.php");
?>