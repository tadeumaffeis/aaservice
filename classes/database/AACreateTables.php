<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
require_once 'AAConnectDB.php';

/**
 * Description of AACreateTables
 *
 * @author Juli e Marina
 */
class AACreateTables {

    private $sql = '';
    public function __construct() {
        
        $approot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
  
        $handle = fopen($approot . "/ED/classes/database/sql/createalltables.sql","r");
        
        while (!feof($handle))
        {
            $row = fgets($handle, 1024);
            $this->sql .= $row;
        }
        
        fclose($handle);
    }

    public function createTables() {
        try {
            AAConnectDB::getConnection()->exec($this->sql);
            echo "Sucesso!";
        } catch (Exception $e) {
            print_r($e);
        }
    }

}
