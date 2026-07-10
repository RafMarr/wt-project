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

    public function get_student_idnumber_from_email(string $email): string|null {
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

    public function getPonies() {
        $query = "SELECT * FROM ponies";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAvailablePonies($day, $start_time, $end_time) {
        $query = 'SELECT * FROM ponies WHERE PonyID NOT IN (SELECT PonyID FROM reservations WHERE Date = ? AND StartHour <= ? AND EndHour >= ?)';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $day, $end_time, $start_time);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function book_pony(int $pony_id, string $date, string $start_hour, string $end_hour, string $student_id): bool {
        $query = 'INSERT INTO reservations VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $pony_id, $date, $start_hour, $end_hour, $student_id);

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

}

?>
