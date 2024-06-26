<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function getDataCSV() {
    $fileClass = 'ed-1.csv';
    $arrAlunos = array();
    if (($handle = fopen($fileClass, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $arrAlunos[$data[0]] = $data[0];
            $arrAlunos[$data[1]] = $data[1];
            $arrAlunos[$data[2]] = $data[2];
        }
    }
    fclose($handle);
    return $arrAlunos;
}

function import_students($data = null) {
    if ($data == null) {
        return null;
    }
    $error = false;
    
    $connection = mysqli_connect("127.0.0.1", "root", "", "aadb");

    $fileClass = 'ed-1.csv';
    $arrAlunos = array();

    if (($handle = fopen($fileClass, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $sql = "INSERT INTO aastudents VALUES ('"
                    . $data[0] . "','"
                    . $data[1] . "','"
                    . $data[2] . "')";

            echo $sql . "\n";
            
            $stmt = mysqli_prepare($connection, $sql);

            if (!mysqli_stmt_execute($stmt)) {
                $this->error = true;
            }

            if ($error) {
                break;
            }
        }
    }
    fclose($handle);

    return ($error);
}

var_dump($data = getDataCSV());
import_students($data);
