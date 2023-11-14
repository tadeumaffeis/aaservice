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
class AASqlTransactionResetPassword {

    private $connection;
    private $login;
    private $passwordHash;
    private $error;
    private $code;

    public function __construct($_login, $_passwordHash, $_code = null) {
        $conn = AAConnectDB::getInstance();
        $this->connection = new mysqli($conn->getHost(), $conn->getUser(), $conn->getPassword(), $conn->getDBName(), $conn->getPort(), "");
        mysqli_autocommit($this->connection, false);
        $this->error = false;
        $this->login = $_login;
        $this->passwordHash = $_passwordHash;
        $this->code = $_code;
    }

    public function run() {
        $this->error = false;

        $sql = "UPDATE aalogin SET temppassword = true WHERE username = '" . $this->login . "'";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt->execute($stmt)) {
            $this->error = true;
        }

        $sql = "INSERT INTO aatemppassword VALUES ('" . $this->login . "','" . $this->passwordHash . "')";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt->execute($stmt)) {
            $this->error = true;
        } 

        if (!$this->error) {
            mysqli_commit($this->connection);
        } else {
            mysqli_rollback($this->connection);
        }

        return (!$this->error); // returns true if no error ocurred
    }

    public function endtransaction() {
        mysqli_close($this->connection);
        $this->connection = null;
    }

}
