<?php

class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function checkLogin($email, $password){
        $query = "SELECT EXISTS(SELECT 1 FROM accounts WHERE Email = ? AND Password = ? LIMIT 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        
        $stmt->bind_result($found);
        $stmt->fetch();
        $stmt->close();

        return (bool)$found;
    }    

    public function registerUser($nome, $cognome, $email, $password, $matricola, $corso) {
        $permission = "Studente";

        $query1 = "INSERT INTO accounts (Email, Password, PermissionType) VALUES (?, ?, ?)";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param('sss', $email, $password, $permission);
        $stmt1->execute();

        $query2 = "INSERT INTO students (Name, Surname, IdNumber, Email, DegreeCourseId) VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param('ssssi', $nome, $cognome, $matricola, $email, $corso);
        $stmt2->execute();

    }

    // exists descritto in https://dev.mysql.com/doc/refman/8.4/en/exists-and-not-exists-subqueries.html
    public function checkEmailRegistered($email) {

        $query = "SELECT EXISTS(SELECT 1 FROM accounts WHERE Email = ? LIMIT 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $stmt->bind_result($found);
        $stmt->fetch();
        $stmt->close();

        return (bool)$found;
    }

    public function checkIdNumberRegistered($idNumber) {

        $query = "SELECT EXISTS(SELECT 1 FROM students WHERE IdNumber = ? LIMIT 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idNumber);
        $stmt->execute();

        $stmt->bind_result($found);
        $stmt->fetch();
        $stmt->close();

        return (bool)$found;
    }

    /**
     * Retrieves the ID number of the student whose email is the provided one.
     * @return null|string the student ID number or `null` if the provided
     * email is not associated with a student
     * */
    public function get_student_idnumber_from_email(string $email): ?string {
        $query = 'SELECT IdNumber FROM students WHERE Email = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $stmt->bind_result($id_number);
        $stmt->fetch();
        $stmt->close();

        return $id_number;
    }

    public function getCourses() {
        $query = "SELECT * FROM degree_courses";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function checkAdmin($idutente) {
        $query = "SELECT PermissionType FROM accounts WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["PermissionType"] === "Admin";
    }

    public function checkStudent($idutente) {
        $query = "SELECT PermissionType FROM accounts WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["PermissionType"] === "Studente";
    }

    private function get_pony_price_filter_query_string(?string $price_filter) {
        $pony_price_filter_query_string = '';
        switch ($price_filter) {
            case '0-5':
                $pony_price_filter_query_string = 'HourlyFee < 5';
                break;
            case '5-10':
                $pony_price_filter_query_string = 'HourlyFee BETWEEN 5 AND 10';
                break;
            case '>10':
                $pony_price_filter_query_string = 'HourlyFee > 10';
                break;
        }
        return $pony_price_filter_query_string;
    }

    public function getPonies(?string $price_filter = null) {
        $query = "SELECT * FROM ponies";
        if ($price_filter !== null) {
            $query = $query . " WHERE " . $this->get_pony_price_filter_query_string($price_filter);
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAvailablePonies(string $day, string $start_time, string $end_time, ?string $price_filter = null) {
        $query = 'SELECT * FROM ponies WHERE PonyID NOT IN (SELECT PonyID FROM reservations WHERE Date = ? AND StartHour <= ? AND EndHour >= ?)';
        if ($price_filter !== null) {
            $query = $query . " AND " . $this->get_pony_price_filter_query_string($price_filter);
        }
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $day, $end_time, $start_time);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Checks whether exists a reservation with the provided ID.
     * @param $reservation_id the reservation ID to check
     * @return bool `true` if already exists a reservation with the provided reservation ID, `false` otherwise
     */
    private function reservation_id_exists(string $reservation_id): bool {
        $query = "SELECT EXISTS(SELECT 1 FROM reservations WHERE ReservationID = ? LIMIT 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $reservation_id);
        $stmt->execute();

        $stmt->bind_result($found);
        $stmt->fetch();
        $stmt->close();

        return (bool)$found;
    }

    /**
     * @return int the maximum length of the database field `reservations.ReservationID`
     */
    private function get_reservation_id_length(): int {
        /* for more info about INFORMATION_SCHEMA.COLUMNS check here:
        https://dev.mysql.com/doc/mysql-infoschema-excerpt/8.0/en/information-schema-columns-table.html */
        $query = 'SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "reservations" AND column_name = "ReservationID"';
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0]["CHARACTER_MAXIMUM_LENGTH"];
    }

    /**
     * Generates a string in a way that it is guaranteed there is no reservation in the database whose ID
     * is the one generated by this function.
     * @return string a valid reservation ID
     */
    private function generate_reservation_id(): string {
        $reservation_id = bin2hex(random_bytes($this->get_reservation_id_length() / 2));
        while ($this->reservation_id_exists($reservation_id)) {
            $reservation_id = bin2hex(random_bytes($this->get_reservation_id_length() / 2));
        }
        return $reservation_id;
    }

    public function book_pony(int $pony_id, string $date, string $start_hour, string $end_hour, string $student_id): bool {
        $reservation_id = $this->generate_reservation_id();
        $query = 'INSERT INTO reservations VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sissss', $reservation_id, $pony_id, $date, $start_hour, $end_hour, $student_id);

        return $stmt->execute();
    }

    /**
     * This function retrieves the pony reservations of the student with the provided student id that would be partially
     * or totally overlapped with a reservation with the provided date, start hour and end hour.
     * @param $date a `Y-m-d` formatted date string, such as '2026-05-23'
     */
    public function get_overlapping_pony_bookings(string $student_id, string $date, string $start_hour, string $end_hour) {
        $query = 'SELECT * FROM reservations WHERE StudentID = ? AND Date = ? AND StartHour <= ? AND EndHour >= ?';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss', $student_id, $date, $end_hour, $start_hour);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Retrieves an associative array containing the pony bookings made
     * by the student with the provided ID that are in the future (the reservation
     * start is after the current datetime).
     * @return array an associative array containing the pony bookings performed
     * by the student whose ID is `$student_id` that are in the future
     */
    public function get_future_pony_bookings(string $student_id): array {
        $query = 'SELECT r.*, p.Name, p.HourlyFee FROM reservations r, ponies p WHERE r.PonyID = p.PonyID AND CONCAT(r.Date, " ", r.StartHour) >= CURRENT_TIMESTAMP() AND r.StudentID = ? ORDER BY r.Date ASC';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $student_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Retrieves an associative array containing the pony bookings made
     * by the student with the provided ID that are in the past (the reservation
     * start is before the current datetime).
     * @return array an associative array containing the pony bookings performed
     * by the student whose ID is `$student_id` that are in the past
     */
    public function get_past_pony_bookings(string $student_id): array {
        $query = 'SELECT r.*, p.Name, p.HourlyFee FROM reservations r, ponies p WHERE r.PonyID = p.PonyID AND CONCAT(r.Date, " ", r.StartHour) < CURRENT_TIMESTAMP() AND r.StudentID = ? ORDER BY r.Date DESC';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $student_id);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Checks if the reservation with the provided ID belongs to the student whose ID number is `$student_id`.
     * @return bool `true` if the reservation with the provided ID belongs to the student whose ID number is `$student_id`,
     * `false` otherwise
     */
    private function is_reservation_of_student(string $reservation_id, string $student_id): bool {
        $query = "SELECT EXISTS(SELECT 1 FROM reservations WHERE ReservationID = ? AND StudentID = ? LIMIT 1)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $reservation_id, $student_id);
        $stmt->execute();

        $stmt->bind_result($found);
        $stmt->fetch();
        $stmt->close();

        return (bool)$found;
    }

    /**
     * Deletes the reservation with the provided ID.
     * @param $booking_id the identifier of the reservation to delete
     * @param $deletion_author_email the email of the person who wants to delete the
     * booking. If `$deletion_author_email` is the email of a student, the reservation
     * with ID `$booking_id` will be deleted only if it belongs to the student whose email
     * is the provided one.
     * If `$deletion_author_email` is the email of an admin, any reservation can be deleted, because
     * an admin can do anything.
     * @return bool `true` on success, `false` on failure
     */
    public function delete_pony_booking(string $booking_id, string $deletion_author_email): bool {
        if ($this->checkAdmin($deletion_author_email)
            || ($this->checkStudent($deletion_author_email) && $this->is_reservation_of_student($booking_id, $this->get_student_idnumber_from_email($deletion_author_email)))) {

            $query = 'DELETE FROM reservations WHERE ReservationID = ?';
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $booking_id);

            return $stmt->execute();
        } else {
            return false;
        }
    } 
}

?>
