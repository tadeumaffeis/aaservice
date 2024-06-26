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
class AASqlTransactionWriteAssignmentFinished {

    private $connection;
    private $assignmentInfo;
    private $username;
    private $error;
    private $code;

    public function __construct($_username = null, $_assignmentInfo = null) {
        $dbpdoconn = AAConnectDB::getInstance();
        //$this->connection = mysqli_connect("aadb.mysql.uhserver.com", "aadbuser", "@IA847atm", "aadb");
        $this->assignmentInfo = $_assignmentInfo;
        $this->connection = mysqli_connect($dbpdoconn->getHost(), $dbpdoconn->getUser(), $dbpdoconn->getPassword(), $dbpdoconn->getDBName());
        mysqli_autocommit($this->connection, false);
        $this->username = $_username;
        if (is_null($_username)) {
            $this->error = true;
        } else {
            $this->error = false;
        }
    }

    public function run() {
        if ($this->error) {
            return $this->error;
        }

        $sql = "SELECT * FROM aaassignmentsfinished WHERE course_id = " . $this->assignmentInfo['course_id'] . " AND "
                . "subject_id = '" . $this->assignmentInfo['subject_id'] . "' AND "
                . "assignment_id = '" . $this->assignmentInfo['assignment_id'] . "' AND "
                . "student_ar = '" . $this->assignmentInfo['student_ar'] . "'";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                throw new Exception("Assignment already finished", 1062);
            }
        }

        $sqlIns = "INSERT INTO aaassignmentsfinished (`course_id`,`subject_id`,`assignment_id`,`student_ar`,`content`) VALUES ("
                . $this->assignmentInfo['course_id']
                . ",'"
                . $this->assignmentInfo['subject_id']
                . "','"
                . $this->assignmentInfo['assignment_id']
                . "','"
                . $this->assignmentInfo['student_ar']
                . "','"
                . $this->assignmentInfo['content']
                . "')";
     
        $this->error = false;
        $this->code = 200;
        $stmt = mysqli_prepare($this->connection, $sqlIns);
        if (!mysqli_stmt_execute($stmt)) {
            $this->error = true;
        }
        
        if (!$this->error) {
            mysqli_commit($this->connection);
        } else {
            mysqli_rollback($this->connection);
            if (mysqli_errno($this->connection) == 1062) {
                throw new Exception("Duplicated primary key",1062);
            } else {
                throw new Exception("internal error: " . mysqli_errno($this->connection)  ,500);
            }
        }

        return $this->code;
    }

    public function endtransaction() {
        mysqli_close($this->connection);
        $this->connection = null;
    }

}
