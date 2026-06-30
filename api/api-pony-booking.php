<?php
require_once "../bootstrap.php";

if (isUserLoggedIn() && isset($_POST['ponyID']) && isset($_POST['day']) && isset($_POST['start']) && isset($_POST['end'])) {
    $pony_id = (int)$_POST['ponyID'];
    $day = $_POST['day'];
    $start_time = $_POST['start'];
    $end_time = $_POST['end'];
    $available_ponies = $dbh->getAvailablePonies($day, $start_time, $end_time);
    $is_booking_successful = false;

    /* TODO: aggiungere altri controlli? Una cosa che si può aggiungere è che un utente non può prenotare un cavallo
             in uno slot di tempo in cui ha già prenotato un altro cavallo (ad esempio se ho prenotato il cavallo 17
             dalle 13 alle 16, non posso prenotare il cavallo 21 dalle 14:30 alle 15:15 perché ho già una prenotazione
             in questo range orario). */
    if (are_pony_parameters_valid($day, $start_time, $end_time) && in_array($pony_id, array_column($available_ponies, 'PonyID'))) {
        $student_id_number = $dbh->get_student_idnumber_from_email($_SESSION['idutente']);
        $is_booking_successful = $dbh->book_pony($pony_id, $day, $start_time, $end_time, $student_id_number);
    }

    header("Content-Type: application/json");
    echo json_encode($is_booking_successful);
}
?>
