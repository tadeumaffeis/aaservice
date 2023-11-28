<?php

require_once 'AAConnectDB.php';
require_once 'AASqlTransactionUpdateTempPassword.php';
require_once 'AASqlTransactionResetPassword.php';
require_once 'AASqlTransactionGetStudentInformation.php';
require_once 'AASqlTransactionGetStudentAssignments.php';
include_once 'AASqlTransactionWriteAssignmentFinished.php';
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LoginGateway
 *
 * @author Juli e Marina
 */
class AALoginGateway {

    private $login;
    private $passwordHash;
    private $connection;
    private $code;

    public function __construct($login, $passwordHash, $code = null, $dbname = null) {
        $this->login = $login;
        $this->passwordHash = $passwordHash;
        $conn = AAConnectDB::getInstance();
        $this->connection = new mysqli($conn->getHost(), $conn->getUser(), $conn->getPassword(), $conn->getDBName(), $conn->getPort(), "");
        $this->code = $code;
    }

    public function validade() {
        $sql = "SELECT * FROM aalogin WHERE username = '" .
                $this->login . "' AND password = '" .
                $this->passwordHash . "'";

        $result = mysqli_query($this->connection, $sql);
        /*
          if ($result) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          if ($row == null) {
          $this->error = true;
          } else {
          $jsonArray['aacourse'] = json_encode($this->toUtf8($row), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
          }
          } else {
          $this->error = true;
          }

          $stmt = $this->connection->query($sql);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
         * */
        $retValue = false;
        if ($result) {
            if ($result->num_rows > 0) {
                $retValue = true;
            }
        }

        return ($retValue);
    }

    public function existsLogin() {
        $sql = "SELECT * FROM aalogin WHERE username = '" .
                $this->login . "'";
        $result = mysqli_query($this->connection, $sql);
        /*
          $stmt = $this->connection->query($sql);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
         * *
         */
        $retValue = false;
        if ($result) {
            if ($result->num_rows > 0) {
                $retValue = true;
            }
        }

        return ($retValue);
    }

    public function getStudentData() {
        // Utilizando prepared statement para evitar injeção de SQL
        $sqlJoin = "SELECT e.course_id, s.initials, st.student_ar, st.name, st.email 
                FROM aastudents as st 
                INNER JOIN aaenrolled as e ON st.student_ar = e.student_ar
                INNER JOIN aasubject as s ON s.initials = e.subject_id
                INNER JOIN aalogin as l ON l.username = st.email
                WHERE l.username = ?";

        // Preparando a declaração
        $stmt = mysqli_prepare($this->connection, $sqlJoin);

        // Verificando se a preparação foi bem-sucedida
        if (!$stmt) {
            die("Falha na preparação da declaração: " . mysqli_error($this->connection));
        }

        // Substituindo o parâmetro por seu valor real
        mysqli_stmt_bind_param($stmt, "s", $this->login);

        // Executando a consulta
        mysqli_stmt_execute($stmt);

        // Obtendo o resultado
        $result = mysqli_stmt_get_result($stmt);

        // Verificando se a execução foi bem-sucedida
        if (!$result) {
            throw new Exception("Falha na execução da consulta: " . mysqli_error($this->connection));
        }

        // Obtendo os dados como um array associativo
        $dataSet = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // Fechando a declaração
        mysqli_stmt_close($stmt);

        return $dataSet;
    }

    /*
      public function getStudentData() {

      $sqlJoin = "SELECT e.course_id, s.initials, st.student_ar, st.name, st.email FROM AAStudents as st "
      . "INNER JOIN aaenrolled as e "
      . "INNER JOIN aasubject as s "
      . "INNER JOIN aalogin as l on l.username = st.email AND st.student_ar = e.student_ar AND s.initials = e.subject_id "
      . "WHERE l.username = '" . $this->login . "'";
      //$stmt = $this->connection->query($sqlJoin);
      //$result = $stmt->fetch(PDO::FETCH_ASSOC);
      $result = mysqli_query($this->connection, $sqlJoin);
      $dataSet = $result->fetch_array(MYSQLI_ASSOC);
      return $dataSet;
      }
     */

    public function validadeUserName() {

        $sqlJoin = "SELECT aastudents.student_ar, aastudents.name, aastudents.email, aalogin.username, aalogin.password"
                . " FROM aastudents INNER JOIN aalogin on aalogin.username = aastudents.email"
                . " WHERE aalogin.username = '" . $this->login . "'";
        $result = mysqli_query($this->connection, $sqlJoin);
        //$stmt = $this->connection->query($sqlJoin);
        //$result = $stmt->fetch(PDO::FETCH_ASSOC);
        $retValue = false;
        if ($result) {
            if ($result->num_rows > 0) {
                $retValue = true;
            }
        }

        return ($retValue);
    }

    public function getData() {
        $sqlJoin = "SELECT aastudents.student_ar, aastudents.name, aastudents.email"
                . " FROM aastudents INNER JOIN aalogin on aalogin.username = aastudents.email"
                . " WHERE aalogin.username = '" . $this->login . "'";
        //$sql = "SELECT * FROM AALogin WHERE username = '" .
        //        $this->login . "'";
        //$stmt = $this->connection->query($sqlJoin);
        //$result = $stmt->fetch(PDO::FETCH_ASSOC);
        //return ($result);
        $result = mysqli_query($this->connection, $sqlJoin);
        $dataSet = $result->fetch_array(MYSQLI_ASSOC);
        return $dataSet;
    }

    public function create() {
        $sql = "INSERT INTO aalogin VALUES ('" .
                $this->login . "','" .
                $this->passwordHash . "', false)";
        try {
            $result = $this->connection->query($sql);
        } catch (Exception $e) {
            $result = false;
        }

        return ($result === TRUE) ? true : false;
    }

    public function resetPassword() {
        $transaction = new AASqlTransactionResetPassword($this->login, $this->passwordHash, $this->code);
        $returnvalue = $transaction->run();
        $transaction->endtransaction();
        $transaction = null;

        return $returnvalue;
    }

    public function updateTempPassword() {
        $transaction = new AASqlTransactionUpdateTempPassword($this->login, $this->passwordHash, $this->code);
        $returnvalue = $transaction->run();
        $transaction->endtransaction();
        return $returnvalue;
    }

    public function existTempPassword() {
        $retValue = false;
        $sql = "SELECT * FROM aatemppassword WHERE username = '" .
                $this->login . "'";
        $result = mysqli_query($this->connection, $sql);

        //$stmt = $this->connection->query($sql);
        //$result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            if ($result->num_rows > 0) {
                $retValue = true;
            }
        }

        return ($retValue);
    }

    public function getAllStudentData() {
        $transaction = new AASqlTransactionGetStudentInformation($this->login);
        $returnvalue = $transaction->run();
        $transaction->endtransaction();
        return $returnvalue;
    }

    public function getAllAssignments() {
        $transaction = new AASqlTransactionGetStudentAssignments($this->login);
        $returnvalue = $transaction->run();
        $transaction->endtransaction();
        return $returnvalue;
    }

    public function writeAssignmentFinished($assignmentInfo) {
        $transaction = new AASqlTransactionWriteAssignmentFinished($this->login, $assignmentInfo);
        $returnvalue = $transaction->run();
        $transaction->endtransaction();
        return $returnvalue;
    }

}
