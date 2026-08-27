<?php
require_once('./../bootstrap.php');

$result = $dbh->getCoursesLabelsWithDegree();

header("Content-Type: application/json");
echo json_encode($result);

?>