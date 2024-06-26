<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ReturnMessage
 *
 * @author Juli e Marina
 */
class ReturnMessage {

    private $message;

    public function __construct($code = null, $message = null) {
        if ($code == null) {
            $this->message = array();
        } else {
            $this->message = array(
                'code' => $code,
                'message' => $message
            );
        }
    }

    public function toJSON() {
        return $this->clearJsonString(json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    private function clearJsonString($jsonArray = null) {
        $str_1 = str_replace("\\", "",
                json_encode($jsonArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $str_2 = str_replace("}\"", "}", $str_1);
        $str_3 = str_replace("\"{", "{", $str_2);
        $str_4 = str_replace("]\"", "]", $str_3);
        $str_5 = str_replace("\"[", "[", $str_4);
        $str_6 = str_replace('\"', '"', $str_5);

        return $str_6;
    }

    public function add($key, $value) {
        $this->message[$key] = $value;
    }

}
