<?php
require_once('./../bootstrap.php');

$result["exists"] = false;
if (isset($_POST["idNumber"])) {
    $idNumber = $_POST["idNumber"];
    $result["exists"] = $dbh->checkIdNumberRegistered($idNumber);
}

header("Content-Type: application/json");
echo json_encode($result);

?>