<?php
session_start();
require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "unibowebapp", 3306);

require_once("utils/cron_clean_report.php");
?>