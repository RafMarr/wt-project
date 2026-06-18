<?php
require_once "../bootstrap.php";

if (isset($_GET['day']) && isset($_GET['start']) && isset($_GET['end'])) {
    $day = $_GET['day'];
    $start_time = $_GET['start'];
    $end_time = $_GET['end'];
    if (are_pony_parameters_valid($day, $start_time, $end_time)) {
        $ponies = $dbh->getAvailablePonies($day, $start_time, $end_time);
    } else {
        $ponies = array();
    }
} else {
    $ponies = $dbh->getPonies();
}

for ($i = 0; $i < count($ponies); $i++) {
    $ponies[$i]["Image"] = UPLOAD_DIR . "img/" . $ponies[$i]["Image"];
}

header("Content-Type: application/json");

echo json_encode($ponies);

?>
