<?php
require_once "../bootstrap.php";

if (isUserLoggedIn() && isset($_POST['ponyID']) && isset($_POST['day']) && isset($_POST['start']) && isset($_POST['end'])) {
    $pony_id = (int)$_POST['ponyID'];
    $day = $_POST['day'];
    $start_time = $_POST['start'];
    $end_time = $_POST['end'];
    $available_ponies = $dbh->getAvailablePonies($day, $start_time, $end_time);
    $is_booking_successful = false;
    $student_id = $dbh->get_student_idnumber_from_email($_SESSION['idutente']);

    if (are_pony_parameters_valid($day, $start_time, $end_time) &&
    in_array($pony_id, array_column($available_ponies, 'PonyID')) &&
    count($dbh->get_overlapping_pony_bookings($student_id, $day, $start_time, $end_time)) == 0) {
        $is_booking_successful = $dbh->book_pony($pony_id, $day, $start_time, $end_time, $student_id);
    }

    header("Content-Type: application/json");
    echo json_encode($is_booking_successful);
}
?>
