<?php
session_start();
define("UPLOAD_DIR", "./upload/");
define("HIPPODROME_OPENING_TIME", "09:00");
define("HIPPODROME_WEEKDAYS_CLOSING_TIME", "18:30");
define("HIPPODROME_WEEKEND_CLOSING_TIME", "13:00");
require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "unibowebapp", 3306);
?>
