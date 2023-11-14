<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Assignment
 *
 * @author Tadeu Maffeis
 */
class Assignment {

    private $ra;
    private $assignment;
    private $subject;

    public function __construct($json_array = null) {
        $this->ra = $json_array['ra'];
        $this->assignment = $json_array['assignment'];
        $this->subject = $json_array['subject'];
    }

    public function create() {
        $gateway = new AAAssignmentGateway($this->ra, $this->subject,null,$this->assignment);
        return $gateway->create();
    }

}
