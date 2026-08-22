<?php
require_once "../bootstrap.php";

$pony_availability_parameter_values = array("available" => true, "not-available" => false);

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit;
}

if (isset($_POST['action'])) {
    if ($_POST['action'] === "book") {
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
        }
    } else if ($_POST['action'] === "delete-booking") {
        if (isset($_POST["booking-id"])) {
            $is_deletion_successful = $dbh->delete_pony_booking($_POST['booking-id'], $_SESSION['idutente']);

            header("Content-Type: application/json");
            echo json_encode($is_deletion_successful);
        }
    } else if ($_POST['action'] === "check-pony-future-reservations") {
        if ($dbh->checkAdmin($_SESSION['idutente']) && isset($_POST['pony-id'])) {
            header("Content-Type: application/json");
            echo json_encode($dbh->has_future_reservations($_POST['pony-id']));
        }
    } else if ($_POST['action'] === "filter" && isset($_POST['period']) && $dbh->checkAdmin($_SESSION['idutente'])) {
        $student_id_parameter = isset($_POST['student-id']) ? $_POST['student-id'] : null;
        $pony_name_parameter = isset($_POST['pony-name']) ? $_POST['pony-name'] : null;
        $is_available_parameter = isset($_POST['pony-availability']) && in_array($_POST['pony-availability'], array_keys($pony_availability_parameter_values)) ? $pony_availability_parameter_values[$_POST['pony-availability']] : null;

        header("Content-Type: application/json");
        if ($_POST['period'] === "future") {
            echo json_encode($dbh->admin_get_future_pony_bookings($student_id_parameter, $pony_name_parameter, $is_available_parameter));
        } else if ($_POST['period'] === "past") {
            echo json_encode($dbh->admin_get_past_pony_bookings($student_id_parameter, $pony_name_parameter, $is_available_parameter));
        }
    }
}

?>
