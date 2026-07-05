<?php
require_once('./../bootstrap.php');

$result = [];
if (isset($_POST["type"])) {
    $type = $_POST["type"];
    $result = $dbh->getPlacesFromType($type);
}

header("Content-Type: application/json");
echo json_encode($result);

?>