<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

if ($dbh->checkStudent($_SESSION['idutente'])) {
    $templateParams["titolo"] = "Campus+ - Annunci di lavoro";
    $templateParams["nome"] = "template/job-posts.php";
    $templateParams["js"] = array("js/job-posts.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js");
    $templateParams["job-posts"] = $dbh->get_job_posts(null, null);
} else if ($dbh->checkAdmin($_SESSION['idutente'])) {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action === "add") {
            $templateParams["titolo"] = "Campus+ - Crea nuovo annuncio di lavoro";
            $templateParams["nome"] = "template/admin/job-posts-form.php";
            $templateParams["js"] = array("js/admin-job-posts-form.js");
            $templateParams["action"] = $_GET['action'];
            $templateParams["degree-courses"] = $dbh->get_degree_courses();
        } else if ($action === "edit" && isset($_GET['job-post-id']) && $dbh->is_job_post_id_valid($_GET['job-post-id'])) {
            $templateParams["titolo"] = "Campus+ - Modifica annuncio di lavoro";
            $templateParams["nome"] = "template/admin/job-posts-form.php";
            $templateParams["js"] = array("js/admin-job-posts-form.js");
            $templateParams["action"] = $_GET['action'];
            $templateParams["job-post"] = $dbh->get_job_post($_GET['job-post-id'])[0];
            $templateParams["degree-courses"] = $dbh->get_degree_courses();
        } else {
            header("location: job-posts.php");
            exit();
        }
    } else {
        $templateParams["titolo"] = "Campus+ - Gestione annunci di lavoro";
        $templateParams["nome"] = "template/admin/job-posts.php";
        $templateParams["js"] = array("js/admin-job-posts.js", "https://cdn.jsdelivr.net/npm/@js-temporal/polyfill/dist/index.umd.js", "js/modal-bs-error.js");
        $templateParams["job-posts"] = $dbh->get_job_posts(null, null);
        $templateParams["degree-courses"] = $dbh->get_degree_courses();
    }

    if (isset($_GET['operation-successful']) && (($_GET['operation-successful'] === "true") || ($_GET['operation-successful'] === "false"))) {
        $templateParams['operation-successful'] = $_GET['operation-successful'] === "true";
    }
}

require("template/base.php");
?>
