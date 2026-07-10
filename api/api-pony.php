<?php
require_once "../bootstrap.php";

if (isset($_GET['day']) && isset($_GET['start']) && isset($_GET['end'])) {
    $day = $_GET['day'];
    $start_time = $_GET['start'];
    $end_time = $_GET['end'];
    if (are_pony_parameters_valid($day, $start_time, $end_time)) {
        $student_id = $dbh->get_student_idnumber_from_email($_SESSION['idutente']);
        if (count($dbh->get_overlapping_pony_bookings($student_id, $day, $start_time, $end_time)) > 0) {
            $result['ponies'] = array();
            $result['error-msg'] = 'Attenzione! Non è possibile prenotare un pony nella fascia oraria selezionata perché per la data '
            . date_format(date_create_from_format('Y-m-d', $day), 'd/m/Y')
            . ' hai già effettuato una prenotazione che si sovrappone con la fascia oraria inserita';
        } else {
            $result['ponies'] = $dbh->getAvailablePonies($day, $start_time, $end_time);
        }
    } else {
        $result['ponies'] = array();
        $result['error-msg'] = 'I parametri di ricerca inseriti non sono validi';
    }
} else {
    $result['ponies'] = $dbh->getPonies();
}

if (count($result['ponies']) == 0 && !array_key_exists('error-msg', $result)) {
    $result['error-msg'] = "Non ci sono pony disponibili";
}

for ($i = 0; $i < count($result['ponies']); $i++) {
    $result['ponies'][$i]["Image"] = UPLOAD_DIR . "img/" . $result['ponies'][$i]["Image"];
}

header("Content-Type: application/json");
echo json_encode($result);

?>
