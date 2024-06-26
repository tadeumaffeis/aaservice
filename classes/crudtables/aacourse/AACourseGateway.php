<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AACourseGateway
 *
 * @author Tadeu Maffeis
 */
class AACourseGateway implements CRUD {

    public function __construct(AACource $aacourse) {
        $this->connection = AAConnectDB::getConnection(null);
        $this->aacourse = $aacourse;
    }

    public function create() {
        $sql = "INSERT INTO aacourse VALUES (0,"
                . "'" . $this->aacourse->getInitials() . "',"
                . "'" . $this->aacourse->getName() . "')";
        
        try {
            $result = $this->connection->exec($sql);
        } catch (Exception $e) {
            $result = false;
        }

        return ($result === false) ? false : true;
    }

    public function delete() {
        $sql = "DELETE FROM aacourse WHERE initials = '" . $this->aacourse->getInitials() . "'";
        try {
            $result = $this->connection->exec($sql);
        } catch (Exception $e) {
            $result = false;
        }

        return ($result === false) ? false : true;
    }

    public function read() {
        $sql = "SELECT * FROM aacourse WHETE initials = '" . $this->aacourse->getInitials() . "'";
        $stmt = $this->connection->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result) ? $result : false;
    }

    public function update() {
        $sql = "UDDATE aacourse"
                . " SET name = '" . $this->aacourse->getName() . "'"
                . " WHERE initials = '" . $this->aacourse->getInitials() . "'";
        try {
            $result = $this->connection->exec($sql);
        } catch (Exception $e) {
            $result = false;
        }

        return ($result === false) ? false : true;
    }

}
