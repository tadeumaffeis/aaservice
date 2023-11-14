<?php

require_once 'AAConnectDB.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$conn = AAConnectDB::getInstance();
$connection = mysqli_connect($conn->getHost(), $conn->getUser(), $conn->getPassword(), $conn->getDBName());

$fileClass = 'email-1.csv';

$students = array();

if (($handle = fopen($fileClass, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $arrAlunos = array();
        $arrAlunos[] = $data[0];
        $arrAlunos[] = $data[1];
        $arrAlunos[] = $data[2];
        $students[] = $arrAlunos;
    }
}

for ($i = 0; $i < sizeof($students); $i++)  {
    
    $sql = "INSERT INTO AAStudents VALUES ('" . utf8_encode($students[$i][0]) 
            . "','" . utf8_encode($students[$i][1])
            . "','" . utf8_encode($students[$i][2])
            . "')";

    echo $sql . "\n";
    $stmt = mysqli_prepare($connection, $sql);
    if (!mysqli_stmt_execute($stmt)) {
        $this->error = true;
    }
}

