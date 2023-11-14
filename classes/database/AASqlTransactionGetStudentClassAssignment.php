<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AASqlTransactionUpdateTempPassword
 *
 * @author Juli e Marina
 */
class AASqlTransactionGetStudentClassAssignment {

    private $connection;
    private $assignments;
    private $username;
    private $error;
    
    public function __construct($username = null, $assignments = null) {
        $this->assignments = null;
        $this->connection = null;
        $this->error = null;
        $this->username = null;
        
        $dbpdoconn = AAConnectDB::getInstance();
        //$this->connection = mysqli_connect("aadb.mysql.uhserver.com", "aadbuser", "@ia847atm", "aadb");
        $this->connection = mysqli_connect($dbpdoconn->getHost(), $dbpdoconn->getUser(),$dbpdoconn->getPassword(), $dbpdoconn->getDBName());
        mysqli_autocommit($this->connection, false);
        $this->username = $username;
        $this->assignments = $assignments;
        if (is_null($username)) {
            $this->error = true;
        } else {
            $this->error = false;
        }
    }

    public function run() {
        if ($this->error) {
            return $this->error;
        }
        $student_ar = "";
        $jsonArray = array();

        $sql = "SELECT * FROM aadb.aastudents WHERE email = '" . $this->username . "'";
        $result = mysqli_query($this->connection, $sql);
        if ($result) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row == null) {
                $this->error = true;
            } else {
                $student_ar = $row['student_ar'];
            }
        } else {
            $this->error = true;
        }

        if ($this->error) {
            return $this->error;
        }

        $sql = "SELECT t1.*, t2.* FROM aadb.AAClassAssignmentFiles t1 "
                . "INNER JOIN aadb.AAClassAssignment t2 "
                . "ON t1.assignment_id = t2.assignment_id "
                . "WHERE t1.assignment_id NOT IN ( "
                . "SELECT t3.assignment_id FROM "
                . "aadb.AAStudentSubjectClassAssignmentsFiles AS t3 "
                . "WHERE t3.student_ar = '" . $student_ar . "');";

        $result = mysqli_query($this->connection, $sql);
        if ($result) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                // criar json
                //print_r($row);
                $jsonArray[] = json_encode($row);
            }
        }    else {
            $this->error = true;
        }

        if ($this->error) {
            return $this->error;
        }

        $jsonResult = json_encode($jsonArray);
        
        return $jsonResult;
    }

    public function endtransaction() {
        mysqli_close($this->connection);
        $this->connection = null;
    }

}
