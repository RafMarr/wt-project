<?php
require_once('./../bootstrap.php');

$result["exists"] = false;
if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $result["exists"] = $dbh->checkEmailRegistered($email);
}

header("Content-Type: application/json");
echo json_encode($result);

?>