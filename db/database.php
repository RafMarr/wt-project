<?php

class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
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

    public function getCourses() {
        $query = "SELECT * FROM degree_courses";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function isStudent($idutente) {
        $checkquery = "SELECT EXISTS(SELECT 1 FROM students WHERE Email = ? LIMIT 1)";
        $stmt = $this->db->prepare($checkquery);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();

        $stmt->bind_result($found);
        $stmt->fetch();
        $stmt->close();

        return (bool)$found;
    }

    public function getProfileInfo($idutente) {
        $found = $this->isStudent($idutente);

        if ($found) {
            $table = "students";
        }
        else {
            $table = "professors";
        }

        $query = "SELECT Name, Surname, IdNumber, Email FROM $table WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function checkAdmin($idutente) {
        $query = "SELECT PermissionType FROM accounts WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["PermissionType"] === "Admin";
    }

    public function checkPasswordRegistered($password, $email) {

        $query = "SELECT Password FROM accounts WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["Password"] === $password;
    }

    public function changePassword($password, $email) {
        $query = "UPDATE accounts SET Password = ? WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $password, $email);
        $stmt->execute();
    }

    public function deleteAccount($email) {
        $found = $this->isStudent($email);
        if ($found) {
            $table = "students";
        }
        else {
            $table = "professors";
        }

        $query1 = "DELETE FROM $table WHERE Email = ?";
        $stmt = $this->db->prepare($query1);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $query2 = "DELETE FROM accounts WHERE Email = ?";
        $stmt = $this->db->prepare($query2);
        $stmt->bind_param('s', $email);
        $stmt->execute();
    }
}

?>
