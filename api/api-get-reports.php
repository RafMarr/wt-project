<?php
require_once('./../bootstrap.php');

$result = [];
if (isset($_POST["luogo"]) && isset($_POST["stato"])) {
    $luogo = $_POST["luogo"];
    $stato = $_POST["stato"];
    $result = $dbh->getReportsFiltered($luogo, $stato);
}

header("Content-Type: application/json");
echo json_encode($result);

?>