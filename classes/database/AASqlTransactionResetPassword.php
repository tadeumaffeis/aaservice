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
            $stmt->sql = $sql;
            echo $this->getSqlFromPreparedStatement($stmt);
            if ($stmt->execute()) {
                // A execução foi bem-sucedida
                // Faça o que precisar aqui
            } else {
                // A execução falhou
                $this->error = true;
            }
            $stmt->close(); // Fechar a declaração
        } else {
            // A preparação da declaração falhou
            $this->error = true;
        }

        $sql = "INSERT INTO aatemppassword VALUES (?,?)";
        $stmt = $this->connection->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $this->login, $this->passwordHash); // "s" representa uma string, ajuste conforme necessário
            $stmt->sql = $sql;
            echo $this->getSqlFromPreparedStatement($stmt);
            if ($stmt->execute()) {
                // A execução foi bem-sucedida
                // Faça o que precisar aqui
            } else {
                // A execução falhou
                $this->error = true;
            }
            $stmt->close(); // Fechar a declaração
        } else {
            // A preparação da declaração falhou
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
    
    private function getSqlFromPreparedStatement($stmt) {
    $sql = $stmt->sql;
    
    foreach ($stmt->params as $param) {
        $value = $stmt->escape_string($param[1]);  // Certifique-se de escapar os valores para evitar injeção de SQL
        $sql = preg_replace('/\?/', "'$value'", $sql, 1);
    }
    
    return $sql;
}

}
