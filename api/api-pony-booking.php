<?php
require_once "../bootstrap.php";

$pony_availability_parameter_values = array("available" => true, "not-available" => false);

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit();
}

$action = null;
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

if ($action === "book") {
    if (isset($_POST['ponyID']) && isset($_POST['day']) && isset($_POST['start']) && isset($_POST['end'])) {
        $pony_id = (int)$_POST['ponyID'];
        $day = $_POST['day'];
        $start_time = $_POST['start'];
        $end_time = $_POST['end'];
        $available_ponies = $dbh->getAvailablePonies($day, $start_time, $end_time, null, false);
        $is_booking_successful = false;
        $student_id = $dbh->get_student_idnumber_from_email($_SESSION['idutente']);

        if (are_pony_parameters_valid($day, $start_time, $end_time) &&
        in_array($pony_id, array_column($available_ponies, 'PonyID')) &&
        count($dbh->get_overlapping_pony_bookings($student_id, $day, $start_time, $end_time)) == 0) {
            $is_booking_successful = $dbh->book_pony($pony_id, $day, $start_time, $end_time, $student_id);
        }

        header("Content-Type: application/json");
        echo json_encode($is_booking_successful);
        exit();
    }
} else if ($action === "delete-booking") {
    if (isset($_POST["booking-id"])) {
        $is_deletion_successful = $dbh->delete_pony_booking($_POST['booking-id'], $_SESSION['idutente']);

        header("Content-Type: application/json");
        echo json_encode($is_deletion_successful);
        exit();
    }
} else if ($action === "check-pony-future-reservations") {
    if ($dbh->checkAdmin($_SESSION['idutente']) && isset($_GET['pony-id'])) {
        header("Content-Type: application/json");
        echo json_encode($dbh->has_future_reservations($_GET['pony-id']));
        exit();
    }
} else if ($action === "filter" && isset($_GET['period']) && $dbh->checkAdmin($_SESSION['idutente'])) {
    $student_id_parameter = isset($_GET['student-id']) ? $_GET['student-id'] : null;
    $pony_name_parameter = isset($_GET['pony-name']) ? $_GET['pony-name'] : null;
    $is_available_parameter = isset($_GET['pony-availability']) && in_array($_GET['pony-availability'], array_keys($pony_availability_parameter_values)) ? $pony_availability_parameter_values[$_GET['pony-availability']] : null;

    header("Content-Type: application/json");
    if ($_GET['period'] === "future") {
        echo json_encode($dbh->admin_get_future_pony_bookings($student_id_parameter, $pony_name_parameter, $is_available_parameter));
    } else if ($_GET['period'] === "past") {
        echo json_encode($dbh->admin_get_past_pony_bookings($student_id_parameter, $pony_name_parameter, $is_available_parameter));
    }
    exit();
}

?>
