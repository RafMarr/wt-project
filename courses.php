<?php
require_once("bootstrap.php");

if(!isUserLoggedIn()) {
    header("location: preview.php");
    exit();
}

$templateParams["titolo"] = "Informazioni sui corsi";
$templateParams["nome"] = "corsi.php";
$templateParams["js"] = array();

if (isset($_GET["courseID"])) {
    if (!$dbh->checkCourseID($_GET["courseID"])) {
        header("location: courses.php");
        exit();
    }
    $templateParams["course-info"] = $dbh->getCourseInfo($_GET["courseID"]);
    $templateParams["course-info"]["course-profs"] = $dbh->getCourseProfessors($_GET["courseID"]);
    $templateParams["titolo"] = $templateParams["course-info"]["Name"] . " - " . $templateParams["course-info"]["CourseID"];
    $templateParams["nome"] = "info-corso.php";
}
else {
    if ($dbh->checkAdmin($_SESSION["idutente"])) {
        $templateParams["admin"] = "";
        $templateParams["lista-corsi"] = $dbh->getCoursesLabels();
        $templateParams["js"] = array("js/corsi-admin.js");
        $templateParams["corsi-laurea"] = $dbh->getDegreeCourses();
    }
    else {
        $templateParams["lista-corsi"] = $dbh->getCoursesLabelsFromEmail($_SESSION["idutente"]);
        $templateParams["degree-type"] = $dbh->getDegreeTypeFromEmail($_SESSION["idutente"])["Type"];
    }
}



require("template/base.php");
?>
