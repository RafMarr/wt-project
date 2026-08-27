<?php
require_once('./../bootstrap.php');

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit();
}

$result = $dbh->getCoursesLabelsWithDegree();

header("Content-Type: application/json");
echo json_encode($result);
exit();

?>
