<?php
require_once('./../bootstrap.php');

$result["match"] = false;
if (isset($_POST['currPass'])) {
    $currPass = $_POST['currPass'];
    $result["match"] = $dbh->checkPasswordRegistered($currPass, $_SESSION["idutente"]);
}

header("Content-Type: application/json");
echo json_encode($result);

?>