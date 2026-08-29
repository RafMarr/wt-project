<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if ($dbh->checkStudent($_SESSION['idutente'])) {
    $templateParams["titolo"] = "Eventi";
    $templateParams["nome"] = "template/events.php";
    $templateParams["js"] = array("js/events.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js");
    $templateParams["events"] = $dbh->get_valid_events(null);
    $templateParams["events-categories"] = $dbh->get_events_categories();
} else if ($dbh->checkAdmin($_SESSION['idutente'])) {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action === "add") {
            $templateParams["titolo"] = "Crea nuovo evento";
            $templateParams["nome"] = "template/admin/events-form.php";
            $templateParams["js"] = array("js/admin-events-form.js");
            $templateParams["action"] = $_GET['action'];
        } else if ($action === "edit" && isset($_GET['event-id']) && $dbh->is_event_id_valid($_GET['event-id'])) {
            $templateParams["titolo"] = "Modifica evento";
            $templateParams["nome"] = "template/admin/events-form.php";
            $templateParams["js"] = array("js/admin-events-form.js");
            $templateParams["action"] = $_GET['action'];
            $templateParams["event"] = $dbh->get_event($_GET['event-id'])[0];
        } else {
            header("location: events.php");
        }
    } else {
        $templateParams["titolo"] = "Gestione eventi";
        $templateParams["nome"] = "template/admin/events.php";
        $templateParams["js"] = array("js/admin-events.js", "js/modal-bs-error.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js");
        $templateParams["valid-events"] = $dbh->get_valid_events(null);
        $templateParams["expired-events"] = $dbh->get_expired_events(null);
        $templateParams["events-categories"] = $dbh->get_events_categories();
    }

    if (isset($_GET['operation-successful']) && (($_GET['operation-successful'] === "true") || ($_GET['operation-successful'] === "false"))) {
        $templateParams['operation-successful'] = $_GET['operation-successful'] === "true";
    }
}

require("template/base.php");
?>
