<?php
require_once('./../bootstrap.php');

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit;
}

$result["success"] = false;
if ($dbh->checkAdmin($_SESSION["idutente"]) && isset($_POST["state"]) && isset($_POST["reportID"])) {
    $state = $_POST["state"];
    $reportID = $_POST["reportID"];
    $result["success"] = $dbh->updateReportState($reportID, $state);
}

header("Content-Type: application/json");
echo json_encode($result);

?>