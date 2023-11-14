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

        $sql = "UPDATE aalogin SET temppassword = true WHERE username = ?";
        $stmt = $this->connection->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $this->login); // "s" representa uma string, ajuste conforme necessário
            if ($stmt->execute()) {
                echo "Update realizado com sucesso" . PHP_EOL;
            } else {
                echo "Update erro: " . $stmt->error . PHP_EOL;
                $this->error = true;
            }
            $stmt->close(); // Fechar a declaração
        } else {
            echo "Update erro: " . $stmt->error . PHP_EOL;
            $this->error = true;
        }

        $sql = "INSERT INTO aatemppassword VALUES (?,?)";
        $stmt = $this->connection->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $this->login, $this->passwordHash); // "s" representa uma string, ajuste conforme necessário
            if ($stmt->execute()) {
                echo "Insert realizado com sucesso" . PHP_EOL;
            } else {
                echo "Insert erro: " . $stmt->error . " " . $stmt->errno . PHP_EOL;
                $this->error = true;
            }
            $stmt->close(); // Fechar a declaração
        } else {
            echo "Insert erro: " . $stmt->error . PHP_EOL;
            $this->error = true;
        }

        if (!$this->error) {
            mysqli_commit($this->connection);
            echo "Commit realizado com sucesso" . PHP_EOL;
        } else {
            mysqli_rollback($this->connection);
            echo "Rollback realizado com sucesso" . PHP_EOL;
        }

        return (!$this->error); // returns true if no error ocurred
    }

    public function endtransaction() {
        mysqli_close($this->connection);
        $this->connection = null;
    }

}
