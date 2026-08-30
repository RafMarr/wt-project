<?php
require_once "../bootstrap.php";

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

if ($action === "filter") {
    $category_filter = isset($_GET['category']) ? $_GET['category'] : null;
    if ($dbh->checkStudent($_SESSION['idutente'])) {

        header("Content-Type: application/json");
        echo json_encode($dbh->get_valid_events($category_filter));
        exit();
    } else if ($dbh->checkAdmin($_SESSION['idutente'])) {
        $result['valid-events'] = $dbh->get_valid_events($category_filter);
        $result['expired-events'] = $dbh->get_expired_events($category_filter);

        header("Content-Type: application/json");
        echo json_encode($result);
        exit();
    }
} else if ($action === "delete" && isset($_POST['event-id']) && $dbh->checkAdmin($_SESSION['idutente'])) {

    header("Content-Type: application/json");
    echo json_encode($dbh->delete_event($_POST['event-id']));
    exit();
} else if ($action === "add" && $dbh->checkAdmin($_SESSION['idutente'])
 && isset($_POST['category']) && isset($_POST['type']) && isset($_POST['title'])
 && isset($_POST['description']) && isset($_POST['place']) && isset($_POST['start-date'])
 && isset($_POST['end-date']) && isset($_POST['start-time']) && isset($_POST['end-time'])) {

    $category = htmlspecialchars(trim($_POST['category']));
    $type = htmlspecialchars(trim($_POST['type']));
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $place = htmlspecialchars(trim($_POST['place']));
    if (strlen($place) === 0) {
        $place = null;
    }
    $start_date = $_POST['start-date'];
    $end_date = null;
    if (strlen($_POST['end-date']) > 0) {
        $end_date = $_POST['end-date'];
    }
    $start_time = null;
    if (strlen($_POST['start-time']) > 0) {
        $start_time = $_POST['start-time'];
    }
    $end_time = null;
    if (strlen($_POST['end-time']) > 0) {
        $end_time = $_POST['end-time'];
    }

    $addition_successful = $dbh->add_event($category, $type, $title, $description,
        $place, $start_date, $end_date, $start_time, $end_time);
        
    header('location: ../events.php?operation-successful=' . ($addition_successful ? "true" : "false"));
    exit();

} else if ($action === "edit" && $dbh->checkAdmin($_SESSION['idutente'])
 && isset($_POST['category']) && isset($_POST['type']) && isset($_POST['title'])
 && isset($_POST['description']) && isset($_POST['place']) && isset($_POST['start-date'])
 && isset($_POST['end-date']) && isset($_POST['start-time']) && isset($_POST['end-time'])
 && isset($_POST['event-id'])) {

    $category = htmlspecialchars(trim($_POST['category']));
    $type = htmlspecialchars(trim($_POST['type']));
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $place = htmlspecialchars(trim($_POST['place']));
    if (strlen($place) === 0) {
        $place = null;
    }
    $start_date = $_POST['start-date'];
    $end_date = null;
    if (strlen($_POST['end-date']) > 0) {
        $end_date = $_POST['end-date'];
    }
    $start_time = null;
    if (strlen($_POST['start-time']) > 0) {
        $start_time = $_POST['start-time'];
    }
    $end_time = null;
    if (strlen($_POST['end-time']) > 0) {
        $end_time = $_POST['end-time'];
    }

    $edit_successful = $dbh->edit_event($category, $type, $title, $description,
        $place, $start_date, $end_date, $start_time, $end_time, (int)$_POST['event-id']);
        
    header('location: ../events.php?operation-successful=' . ($edit_successful ? "true" : "false"));
    exit();
}
?>
