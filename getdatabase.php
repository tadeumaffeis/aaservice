<?php


function getReturnText($id,$databaseStr)
{
    return $id . ',' . $databaseStr;

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

function getDatabase($database)
{
    $file = $database;
    $content = "";
    if (($handle = fopen($file, 'r')) !== false) {
        while (($data = fgets($handle, 1000)) !== false) {
            $content .= $data;
        }
    }
    fclose($handle);
    return $content;
}

function main()
{
    
    //echo getReturnText(false,"Finalizou o prazo para a entrega da atividade!");
    //die();

    $path = 'data/database';
    $assignment    = "Lista003 - Estrutura de Dados";


    if (!filter_has_var(INPUT_POST, 'database'))
    {
        //echo getReturnText("NOK","Malformed request");
        //die();
    }
    
    $content = getDatabase($path);
    echo getReturnText($assignment, $content);
    
    die();
}

main();