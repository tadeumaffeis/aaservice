<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class AAAssignmentGateway {
    private $ra;
    private $assignment;
    private $subject;
    private $connection;
    
    public function __construct($ra, $subject, $assignment) {
        $this->ra = $ra;
        $this->assignment = $assignment;
        $this->subject = $subject;
        $this->connection = AAConnectDB::getConnection();
    }

    public function create() {
        $sql = 'INSERT INTO aasimplesubject ';
        // PAREI AQUI
    }

}
