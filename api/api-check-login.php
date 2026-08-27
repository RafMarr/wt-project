<?php
require_once('./../bootstrap.php');

$result["exists"] = false;
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result["exists"] = $dbh->checkLogin($email, $password);
}

header("Content-Type: application/json");
echo json_encode($result);
exit();

?>
