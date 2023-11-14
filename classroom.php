<?php


function getReturnText($status,$text)
{
    if ($status)
    {
        return "OK,".$text;
    }
    else
    {
        return "NOK,".$text;
    }
}

function getDataCSV()
{
    $fileClass = 'data/alunos_ed.csv';
    $arrAlunos = array();
    if (($handle = fopen($fileClass, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $arrAlunos[$data[0]] = $data[1];
        }
    }
    fclose($handle);
    return $arrAlunos;
}

function getAssigmentCSV()
{
    $fileAssigment = 'data/assigments';
    $arrAssigment = array();
    if (($handle = fopen($fileAssigment, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $arrAssigment[$data[0]] = $data[1];
        }
    }
    fclose($handle);
    return $arrAssigment;
}

function main()
{
    
    //echo getReturnText(false,"Finalizou o prazo para a entrega da atividade!");
    //die();

    $fileAssigment = 'data/assigments';

    if (!filter_has_var(INPUT_POST, 'ra'))
    {
        echo getReturnText(false,"Incorrect RA");
        die();
    }

    if (!filter_has_var(INPUT_POST, 'assigment'))
    {
        echo getReturnText(false,"Incorrect assigment");
        die();
    }

    $ra = filter_input(INPUT_POST, 'ra', FILTER_SANITIZE_STRING);;
    $assigment = filter_input(INPUT_POST, 'assigment', FILTER_SANITIZE_STRING);

    $arr = getDataCSV();

    if (!array_key_exists($ra, $arr))
    {
        echo getReturnText(false, $ra." does not exists");
        die();
    }
    
    $arrAssigment = getAssigmentCSV();
    
    if (array_key_exists($ra, $arrAssigment))
    {
        echo getReturnText(false,"Assigment already was saved in assigment file");
        die();
    }
    
    $bytesRec = file_put_contents($fileAssigment,$ra.','.$assigment.PHP_EOL, FILE_APPEND);
    
    if ($bytesRec !== false) {
        echo getReturnText(true,"The assigment is saved for  RA: ".$ra);
    } 
    else 
    {
        echo getReturnText(false,"ERROR: saving data");
    }
    
    die();
}

main();