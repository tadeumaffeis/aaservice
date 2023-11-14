<?php

require_once 'database/AALoginGateway.php';
require_once 'database/AAStudentsGateway.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Login
 *
 * @author Juli e Marina
 */
class Login {

    private $username;
    private $password;
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

    public function __construct($username, $password, $dbname = null) {
        $this->username = $username;
        $this->password = $password;
        $this->sqlitedbname = $dbname;
    }

    public function isValid() {
        $gateway = new AALoginGateway($this->username, $this->password, null, $this->sqlitedbname);
        return $gateway->validade();
    }

    public function isUserNameValid() {
        $gateway = new AALoginGateway($this->username, $this->password, null, $this->sqlitedbname);
        return $gateway->validadeUserName();
    }

    public function existsStudent() {
        $gateway = new AAStudentsGateway();
        $result = $gateway->getByEmail($this->username);
        return $result ? true : false;
    }

    public function existsLogin() {
        $gateway = new AALoginGateway($this->username, $this->password, null, $this->sqlitedbname);
        return $gateway->existsLogin();
    }

}
