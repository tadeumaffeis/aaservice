<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of aacourse
 *
 * @author Tadeu Maffeis
 */
class AACourse implements CRUD {

    private $id;
    private $initials;
    private $name;

    public function __construct($json_array = null) {
        if ($json_array == null) {
            throw new Exception("JSON string is null");
        }
        if (isset($json_array['course_id']))
        {
            $this->id = $json_array['course_id'];
        }
        $this->setInitials($json_array['initials']);
        $this->setName($json_array['name']);
    }

    public function getInitials() {
        return $this->initials;
    }

    public function getName() {
        return $this->name;
    }

    public function setInitials($initials): void {
        $this->initials = $initials;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    /*
     * CRUD methods
     */

    public function create() {
        $result = null;
        $gateway = new AACourseGateway($this);
        try {
            $result = $gateway->create();
        } catch (Exception $ex) {
            throw $ex;
        }
        
        return $result;
    }

    public function read() {
        
    }

    public function update() {
        
    }

    public function delete() {
        
    }

}
