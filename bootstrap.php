<?php
session_start();

define("IMG_UPLOAD_DIR", "./upload/img/");
define("HIPPODROME_OPENING_TIME", "09:00");
define("HIPPODROME_WEEKDAYS_CLOSING_TIME", "18:30");
define("HIPPODROME_WEEKDAYS_LAST_BOOKING_START_TIME", "18:00");
define("HIPPODROME_WEEKEND_CLOSING_TIME", "13:00");
define("HIPPODROME_WEEKEND_LAST_BOOKING_START_TIME", "12:30");

require_once("utils/functions.php");
require_once("db/database.php");

/* In order for the transactions to behave properly, it must be enabled exception error reporting.
   For further information, see https://stackoverflow.com/questions/12091971/how-to-start-and-end-transaction-in-mysqli/63764001#63764001 */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbh = new DatabaseHelper("localhost", "root", "", "unibowebapp", 3306);

require_once("utils/cron_clean_report.php");
?>
