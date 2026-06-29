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

    public function checkAdmin($idutente) {
        $query = "SELECT PermissionType FROM accounts WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()["PermissionType"] === "Admin";
    }

    public function getProfileInfo($idutente) {
        $found = $this->checkAdmin($idutente);

        if ($found) {
            $query = "SELECT Name, Surname FROM admins WHERE Email = ?";
        }
        else {
            $query = "SELECT Name, Surname, IdNumber FROM students WHERE Email = ?";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getAccountsExceptCurrent($currentId) {
        $query = "SELECT Name, Surname, Email FROM students WHERE Email != ? UNION SELECT Name, Surname, Email FROM admins WHERE Email != ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $currentId, $currentId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function registerAdmin($nome, $cognome, $email, $password) {
        $permission = "Admin";

        $query1 = "INSERT INTO accounts (Email, Password, PermissionType) VALUES (?, ?, ?)";
        $stmt1 = $this->db->prepare($query1);
        $stmt1->bind_param('sss', $email, $password, $permission);
        $stmt1->execute();

        $query2 = "INSERT INTO admins (Name, Surname, Email) VALUES (?, ?, ?)";
        $stmt2 = $this->db->prepare($query2);
        $stmt2->bind_param('sss', $nome, $cognome, $email);
        $stmt2->execute();
    }

    public function deleteAccount($email) {
        $found = $this->checkAdmin($email);
        if ($found) {
            $table = "admins";
        }
        else {
            $table = "students";
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

    public function getReports() {
        $query = "SELECT * FROM signals";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getBathrooms() {
        $query = "SELECT * FROM bathrooms";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTeachingPlaces() {
        $query = "SELECT * FROM teaching_places";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAulee() {
        $aula = "AULA";
        $query = "SELECT * FROM teaching_places WHERE Type = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $aula);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLabs() {
        $lab = "LAB.";
        $query = "SELECT * FROM teaching_places WHERE Type = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $lab);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTeachingPlaceType($teachingPlaceID) {
        $query = "SELECT Type FROM teaching_places WHERE TeachingPlaceID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $teachingPlaceID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getBathroom($bathroomID) {
        $query = "SELECT Floor, Block FROM bathrooms WHERE BathroomID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $bathroomID);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getStudentID($email) {
        $query = "SELECT IdNumber FROM students WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function addReport($type, $placetype, $placeId, $description, $studentId) {
        $currentDate = date("Y-m-d");
        $state = "Non Risolto";
        if ($placetype === "Corridor") {
            $query = "INSERT INTO signals(CreationDate, State, Description, Type, StudentID, CorridorFloor, CorridorBlock) VALUES (?,?,?,?,?,?,?)";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssssis', $currentDate, $state, $description, $type, $studentId, $placeId["piano"], $placeId["blocco"]);
        }
        else if ($placetype === "Bike-Parking") {
            $query = "INSERT INTO signals(CreationDate, State, Description, Type, StudentID, Bike-Parking) VALUES (?,?,?,?,?,?)";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssssi', $currentDate, $state, $description, $type, $studentId, $placeId);
        }
        else {
            if ($placetype === "AULA" || $placetype === "LAB.") {
                $query = "INSERT INTO signals(CreationDate, State, Description, Type, StudentID, TeachingPlaceID) VALUES (?,?,?,?,?,?)";
            }
            else if ($placetype === "Bathroom") {
                $query = "INSERT INTO signals(CreationDate, State, Description, Type, StudentID, BathroomID) VALUES (?,?,?,?,?,?)";
            }
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssssss', $currentDate, $state, $description, $type, $studentId, $placeId);
        }

        $stmt->execute();
    }
}

?>
