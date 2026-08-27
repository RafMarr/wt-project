<?php
require_once "../bootstrap.php";

$price_filter_allowed_values = array('0-5', '5-10', '>10');
$price_filter_parameter = isset($_GET['price-filter']) && in_array($_GET['price-filter'], $price_filter_allowed_values) ? $_GET['price-filter'] : null;

if (!isUserLoggedIn()) {
    http_response_code(401);
    exit();
}

$is_student = $dbh->checkStudent($_SESSION['idutente']);

if (!$is_student && isset($_POST['action']) && isset($_POST['pony-id'])) {
    if ($_POST['action'] === "hide" && isset($_POST['delete-future-bookings']) && ($_POST['delete-future-bookings'] === "true" || $_POST['delete-future-bookings'] === "false")) {
        header("Content-Type: application/json");
        echo json_encode($dbh->hide_pony($_POST['pony-id'], $_POST['delete-future-bookings'] === "true"));
    } else if ($_POST['action'] === "make-visible") {
        header("Content-Type: application/json");
        echo json_encode($dbh->make_pony_visible($_POST['pony-id']));
    }
    exit();
}

if (isset($_GET['day']) && isset($_GET['start']) && isset($_GET['end'])) {
    $day = $_GET['day'];
    $start_time = $_GET['start'];
    $end_time = $_GET['end'];
    /* If the logged user is a student, the check on the minimum duration must be performed;
    otherwise, if the logged user is an admin, the check on the minimum duration must not be performed,
    because an admin can see the pony availability for every time interval. */
    if (are_pony_parameters_valid($day, $start_time, $end_time, $is_student)) {
        $student_id = $dbh->get_student_idnumber_from_email($_SESSION['idutente']);
        if ($is_student && count($dbh->get_overlapping_pony_bookings($student_id, $day, $start_time, $end_time)) > 0) {
            $result['ponies'] = array();
            $result['error-msg'] = 'Attenzione! Non è possibile prenotare un pony nella fascia oraria selezionata perché per la data '
            . date_format(date_create_from_format('Y-m-d', $day), 'd/m/Y')
            . ' hai già effettuato una prenotazione che si sovrappone con la fascia oraria inserita';
        } else {
            // If the logged user is not a student it has to be an admin, and so also the hidden ponies must be shown
            $result['ponies'] = $dbh->getAvailablePonies($day, $start_time, $end_time, $price_filter_parameter, !$is_student);
        }
    } else {
        $result['ponies'] = array();
        $result['error-msg'] = 'I parametri di ricerca inseriti non sono validi';
    }
} else {
    $result['ponies'] = $dbh->getPonies($price_filter_parameter, !$is_student);
}

if ((count($result['ponies']) == 0 || !in_array(true, array_column($result['ponies'], 'IsAvailable'))) && !array_key_exists('error-msg', $result)) {
    $result['error-msg'] = "Non ci sono pony disponibili";
}

for ($i = 0; $i < count($result['ponies']); $i++) {
    $result['ponies'][$i]["Image"] = IMG_UPLOAD_DIR . $result['ponies'][$i]["Image"];
}

header("Content-Type: application/json");
echo json_encode($result);
exit();

?>
