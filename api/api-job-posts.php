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
    $degree_course_parameter = null;
    if (isset($_GET['category'])) {
        $degree_course_parameter = $_GET['category'] === "general" ? $_GET['category'] : (int)$_GET['category'];
    }
    $contract_type_parameter = isset($_GET['contract-type']) ? $_GET['contract-type'] : null;

    header("Content-Type: application/json");
    echo json_encode($dbh->get_job_posts($degree_course_parameter, $contract_type_parameter));
    exit();
} else if ($action === "delete" && isset($_POST['job-post-id'])) {

    header("Content-Type: application/json");
    echo json_encode($dbh->delete_job_post($_POST['job-post-id']));
    exit();
} else if ($action === "add" && $dbh->checkAdmin($_SESSION['idutente'])
 && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['contract-type'])
 && isset($_POST['description']) && isset($_POST['working-time']) && isset($_POST['enterprise-address'])
 && isset($_POST['hourly-salary']) && isset($_POST['author-phone-number']) && isset($_POST['author-email'])
 && isset($_POST['degree-course-choice'])) {

    $title = htmlspecialchars(trim($_POST['title']));
    $author = htmlspecialchars(trim($_POST['author']));
    $description = htmlspecialchars(trim($_POST['description']));
    $working_time = htmlspecialchars(trim($_POST['working-time']));
    $enterprise_address = htmlspecialchars(trim($_POST['enterprise-address']));
    $author_phone_number = htmlspecialchars(trim($_POST['author-phone-number']));
    $author_email = htmlspecialchars(trim($_POST['author-email']));
    $degree_course_id = null;
    if ($_POST['degree-course-choice'] === "yes" && isset($_POST['degree-course'])) {
        $degree_course_id = $_POST['degree-course'];
    }

    $addition_successful = $dbh->add_job_post($title, $author, $description, $working_time,
        $enterprise_address, $_POST['hourly-salary'], $_POST['contract-type'], $author_phone_number,
        $author_email, $degree_course_id);
        
    header('location: ../job-posts.php?operation-successful=' . ($addition_successful ? "true" : "false"));
    exit();

} else if ($action === "edit" && $dbh->checkAdmin($_SESSION['idutente'])
 && isset($_POST['title']) && isset($_POST['author']) && isset($_POST['contract-type'])
 && isset($_POST['description']) && isset($_POST['working-time']) && isset($_POST['enterprise-address'])
 && isset($_POST['hourly-salary']) && isset($_POST['author-phone-number']) && isset($_POST['author-email'])
 && isset($_POST['degree-course-choice']) && isset($_POST['job-post-id'])) {

    $title = htmlspecialchars(trim($_POST['title']));
    $author = htmlspecialchars(trim($_POST['author']));
    $description = htmlspecialchars(trim($_POST['description']));
    $working_time = htmlspecialchars(trim($_POST['working-time']));
    $enterprise_address = htmlspecialchars(trim($_POST['enterprise-address']));
    $author_phone_number = htmlspecialchars(trim($_POST['author-phone-number']));
    $author_email = htmlspecialchars(trim($_POST['author-email']));
    $degree_course_id = null;
    if ($_POST['degree-course-choice'] === "yes" && isset($_POST['degree-course'])) {
        $degree_course_id = $_POST['degree-course'];
    }

    $edit_successful = $dbh->edit_job_post($title, $author, $description, $working_time,
        $enterprise_address, $_POST['hourly-salary'], $_POST['contract-type'], $author_phone_number,
        $author_email, $degree_course_id, $_POST['job-post-id']);
        
    header('location: ../job-posts.php?operation-successful=' . ($edit_successful ? "true" : "false"));
    exit();
}
?>
