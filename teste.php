<?php

$b64login = base64_encode("aaclassroom@atmapps.pro.br");
$b64password = base64_encode("@IA847atm");

echo "Login   : " . $b64login    . PHP_EOL;
echo "Password: " . $b64password . PHP_EOL;

echo "Login   : " . base64_decode($b64login)    . PHP_EOL;
echo "Password: " . base64_decode($b64password) . PHP_EOL;


/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

