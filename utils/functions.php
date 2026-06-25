<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idutente']);
}

function registerLoggedUser($idutente){
    $_SESSION["idutente"] = $idutente;
}

/**
 * This function controls if all the provided booking/search pony parameters are valid. The criteria used for the checks are the following:
 * * `day` must be at least the current date;
 * * if `day` is the current date, `start_time` must be at least the current time;
 * * `start_time` and `end_time` must be between `HIPPODROME_OPENING_TIME` and `HIPPODROME_WEEKDAYS_CLOSING_TIME` if the week day of `day` is between Monday and Friday; otherwise they must be between `HIPPODROME_OPENING_TIME` and `HIPPODROME_WEEKEND_CLOSING_TIME`;
 * * `end_time` must be at least `start_time`
 * @return bool `true` is all the parameters are valid, `false` otherwise
 */
function are_pony_parameters_valid(string $day, string $start_time, string $end_time) : bool {
    $current_datetime = date("Y-m-d H:i");
    $start_datetime = $day . " " . $start_time;
    $closing_time = get_hippodrome_closing_time($day);

    return ($start_datetime >= $current_datetime)
        && ($start_time >= HIPPODROME_OPENING_TIME) && ($start_time <= $closing_time)
        && ($end_time >= HIPPODROME_OPENING_TIME) && ($end_time <= $closing_time)
        && ($end_time >= $start_time);
}

/**
 * This function retrieves the hippodrome closing time in the provided date.
 * @param $day a `Y-m-d` formatted date string, such as '2026-05-23'
 * @return string a formatted time string. It is `HIPPODROME_WEEKEND_CLOSING_TIME` if the day of week of `$day`
 * is Saturday or Sunday;
 * `HIPPODROME_WEEKDAYS_CLOSING_TIME` otherwise.
 */
function get_hippodrome_closing_time(string $day) : string {
    $sunday = 0;
    $saturday = 6;
    $day_of_week = getdate(date_timestamp_get(date_create_from_format("Y-m-d", $day)))['wday'];
    
    return ($day_of_week == $sunday) || ($day_of_week == $saturday) ? HIPPODROME_WEEKEND_CLOSING_TIME : HIPPODROME_WEEKDAYS_CLOSING_TIME;
}

?>
