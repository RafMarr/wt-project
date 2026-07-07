<?php
require_once('./../bootstrap.php');

$result = [];
if (isset($_SESSION["idutente"]) && isset($_POST["date"]) && isset($_POST["year"])) {
    $date = $_POST["date"];
    $year = $_POST["year"];
    $result = $dbh->getLessonsFiltered($date, $year, $_SESSION["idutente"]);
}

header("Content-Type: application/json");
echo json_encode($result);

?>