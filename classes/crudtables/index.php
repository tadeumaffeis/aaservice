<?php

include_once '../interface/CRUD.php';
include_once './aacourse/AACourse.php';
include_once '../ReturnMessage.php';
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of index
 *
 * @author Tadeu Maffeis
 */
class index {

    private $table = null;
    private $json_array = null;

    public function __construct($query_string = null) {
        switch ($query_string) {
            case "aacourse" : {
                    $this->json_array = $this->getInputPostJson();
                    $this->table = new AACourse($this->json_array);
                }
            case "aasubject" : {
                    //$json_array = $this->getInputPostJson();
                    //$this->table = new AASubject($json_array);
                }
        }
    }

    private function getInputPostJson() {
        if (!filter_has_var(INPUT_POST, 'json')) {
            $jsonObj = new ReturnMessage(400, 'No information');
            echo $jsonObj->toJSON();
            die();
        }
        $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
        return json_decode($json_received, true);
    }

    public function execute($op = null) {
        switch ($op) {
            case 'create' : {
                    $result = $table->create();
                }
            case 'read' : {
                    $result = $table->read();
                }
            case 'update' : {
                    $result = $table->update();
                }
            case 'delete' : {
                    $result = $table->delete();
                }
        }
        
        header('content-type: application/json');
        
        return $result;
    }
    
    public function getJsonArray()
    {
        return $this->json_array;
    }

}

function main() {
    if (!filter_has_var(INPUT_SERVER, 'QUERY_STRING')) {
        $jsonObj = new ReturnMessage(404, 'No method defined');
        echo $jsonObj->toJSON();
        return;
    }

    try {
        $index = new index(filter_input(INPUT_SERVER, 'QUERY_STRING'));
        $json_array = $index->getJsonArray();
        $index->execute($json_array['crudop']);
        var_dump($index);
        if ($index) {
            $jsonObj = new ReturnMessage(200, 'Create sucessful');
        } else {
            $jsonObj = new ReturnMessage(400, 'Create error');
        }
    } catch (Exception $ex) {
        $jsonObj = new ReturnMessage(500, 'Exception: ' . $ex->getMessage());
    }

    echo $jsonObj->toJSON();
    die(0);
}

main();