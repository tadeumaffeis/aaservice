<?php

require './AASqlTransactionGetStudentInformation.php';

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of index
 *
 * @author Tadeu Maffeis
 */
final class index {
    private static $_status = null;
    private  function __construct($username = null) {
        $obj = new AASqlTransactionGetStudentInformation($username);
        self::$_status = $obj->run();
        header('Content-Type: text/html; charset=utf-8');
    }
    
    public static function start()
    {
        new index('tadeu.maffeis@fatec.sp.gov.br');
        return "<p>Ok</p>";
    }
    
    public static function status()
    {
        $sts = self::$_status;
        return $sts;
    }
}
?>    
    
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?=index::start();?>
        <?=index::status();?>
    </body>
</html>    

