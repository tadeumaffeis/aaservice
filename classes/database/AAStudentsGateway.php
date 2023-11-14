<?php

require_once 'AAConnectDB.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LoginGateway
 *
 * @author Juli e Marina
 */
class AAStudentsGateway {

    private $course;
    private $student_ar;
    private $name;
    private $email;
    private $connection;

    public function __construct() {
        $conn = AAConnectDB::getInstance();
        $this->connection = new mysqli($conn->getHost(), $conn->getUser(), $conn->getPassword(), $conn->getDBName(), $conn->getPort(), "");
    }

    public function getByStudentAr($student_ar) {
        $sql = "SELECT * FROM aastudents WHERE student_ar = '" .
                $student_ar . "'";
        /*
          $stmt = $this->connection->query($sql);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return ($result);
         * *
         */
        $result = mysqli_query($this->connection, $sql);

        //$stmt = $this->connection->query($sql);
        //$result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dataSet = $result->fetch_array(MYSQLI_ASSOC);
        return $dataSet;
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM aastudents WHERE email = '" .
                $email . "'";
        $result = mysqli_query($this->connection, $sql);
        $dataSet = $result->fetch_array(MYSQLI_ASSOC);
        return $dataSet;
    }

    public function getData() {
        $sqlJoin = "SELECT aastudents.student_ar, aastudents.name, aastudents.email"
                . " FROM aastudents INNER JOIN aalogin on aalogin.username = aastudents.email"
                . " WHERE aalogin.username = '" . $this->login . "'";
        //$sql = "SELECT * FROM AALogin WHERE username = '" .
        //        $this->login . "'";
        $result = mysqli_query($this->connection, $sqlJoin);
        $dataSet = $result->fetch_array(MYSQLI_ASSOC);
        return $dataSet;
    }

    public function create() {


        //return ($result === false) ? false : true;
    }

}
