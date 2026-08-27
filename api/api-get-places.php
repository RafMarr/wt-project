<?php
require_once('./../bootstrap.php');

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit;
}

$result = [];
if (isset($_POST["type"])) {
    $type = $_POST["type"];
    $result = $dbh->getPlacesFromType($type);
}

header("Content-Type: application/json");
echo json_encode($result);

?>