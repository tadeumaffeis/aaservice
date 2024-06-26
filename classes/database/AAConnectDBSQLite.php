<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AAConnectDB
 *
 * @author Juli e Marina
 */
final class AAConnectDBSQLite {

    private static $instance = null;
    private static $connection = null;
    private static $database_path = null;

    private function __construct($db_path = null) {
        if ($db_path == null and self::$database_path == null) {
            return;
        }
        if (self::$database_path == null) {
            self::$database_path = $db_path;
        }
        if (self::$connection == null) {
            self::$connection = new PDO("sqlite:" . self::$database_path);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        echo self::$database_path;
    }

    public static function getConnection($db_path = null) {
        if ($db_path == null and self::$database_path == null) {
            throw new Exception("No database path defined");
        }
        if (self::$connection == null) {
            self::$instance = new AAConnectDB($db_path);
        }

        return self::$connection;
    }

}
