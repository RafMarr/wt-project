<?php
require_once('./../bootstrap.php');

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit();
}

$result["success"] = false;
if ($dbh->checkAdmin($_SESSION["idutente"]) && isset($_POST["reportID"])) {
    $reportID = $_POST["reportID"];
    $result["success"] = $dbh->deleteReport($reportID);
}

header("Content-Type: application/json");
echo json_encode($result);
exit();

?>
