<?php

require_once 'AAConnectDB.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AASqlTransactionGetStudentInformation
 *
 * @author Tadeu Maffeis
 */
/*
 * select t1.initials as course, t1.name as name , t2.initials as subject, t2.`name` as subject_name, t3.student_ar, t4.name from aadb.aacourse t1 inner join aadb.aasubject t2 inner join aadb.aaenrolled t3 inner join aadb.aastudents t4 on t3.subject_id = t2.initials;

 */
class AASqlTransactionGetStudentAssignments {
    private $connection;
    private $username;
    private $assignments;
    private $error;
    
    public function __construct($_username = null, $_assignments = null) {
        $dbpdoconn = AAConnectDB::getInstance();

        //$this->connection = mysqli_connect("aadb.mysql.uhserver.com", "aadbuser", "@ia847atm", "aadb");
        $this->connection = mysqli_connect($dbpdoconn->getHost(), $dbpdoconn->getUser(), $dbpdoconn->getPassword(), $dbpdoconn->getDBName());
        mysqli_autocommit($this->connection, false);
        $this->connection->set_charset("utf8");
        $this->username = $_username;
        $this->assignments = $_assignments;
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
        
        $sql = "SELECT * FROM aaassignments AS a "
                . "INNER JOIN aasubject as sub ON sub.initials = a.subject_id "
                . "WHERE a.assignment_id NOT IN "
                . "(SELECT assignment_id FROM aaassignmentsfinished WHERE student_ar IN "
                . "(SELECT student_ar FROM aastudents WHERE email = '" . $this->username . "'))";

        $result = mysqli_query($this->connection, $sql);
        
        $json_assignment = array();
        
        if ($result) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $json_assignment[] = $row;
            }
        } else {
            $this->error = true;
        }

        if ($this->error) {
            echo $result;
            throw new Exception("Exception AAAssignment",500);
        }

        $jsonArray['aaassignments'] = $json_assignment;

        return $this->clearJsonString($jsonArray);
    }

    private function clearJsonString($jsonArray = null) {

        $str_1 = str_replace("\\", "",
                json_encode($jsonArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $str_2 = str_replace("}\"", "}", $str_1);
        $str_3 = str_replace("\"{", "{", $str_2);
        $str_4 = str_replace("]\"", "]", $str_3);
        $str_5 = str_replace("\"[", "[", $str_4);
        $str_6 = str_replace('\"', '"', $str_5);

        return $str_6;
    }

    private function toUtf8($arrAssoc) {
        $arrUtf8 = array();
        foreach ($arrAssoc as $key => $value) {
            $arrUtf8[utf8_encode($key)] = utf8_encode($value);
        }
        return $arrAssoc;
    }

    public function endtransaction() {
        mysqli_close($this->connection);
        $this->connection = null;
    }

}
