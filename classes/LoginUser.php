<?php

include_once 'database/AALoginGateway.php';


/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LoginUser
 *
 * @author Juli e Marina
 */
class LoginUser {

    private $username;
    private $password;
    private $code;
    private $sqlitedbname;

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function __construct($username = null, $password = null, $code = null, $dbname = null) {
        $this->username = $username;
        $this->code = $code;
        $this->password = $password;
        $this->sqlitedbname = $dbname;
    }

    public function create() {
        $gateway = new AALoginGateway($this->username, $this->password, null, $this->sqlitedbname);
        return $gateway->create();
    }

    public function updateTempPassword() {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->updateTempPassword();
    }

    public function resetPassword() {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->resetPassword();
    }

    public function getStudentData() {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->getStudentData();
    }

    public function existTempPassword() {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->existTempPassword();
    }

    public function getAllStudentData() {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->getAllStudentData();
    }

    public function getAllAssignments() {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->getAllAssignments();
    }
    
    public function writeAssignmentFinished($assignmentInfo) {
        $gateway = new AALoginGateway($this->username, $this->password, $this->code, $this->sqlitedbname);
        return $gateway->writeAssignmentFinished($assignmentInfo);
    }

    
}
