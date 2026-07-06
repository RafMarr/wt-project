<?php
require_once('./../bootstrap.php');

$result["success"] = false;
if ($dbh->checkAdmin($_SESSION["idutente"]) && isset($_POST["reportID"])) {
    $reportID = $_POST["reportID"];
    $result["success"] = $dbh->deleteReport($reportID);
}

header("Content-Type: application/json");
echo json_encode($result);

?>