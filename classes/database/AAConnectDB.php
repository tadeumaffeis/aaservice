<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AAConectDB
 *
 * @author Juli e Marina
 */
final class AAConnectDB {

    private static $instance = null;
    private static $connection = null;
    // Local
    private const SGBD_URI = "mysql:host=127.0.0.1";
    private const SGBD_DBNAME = "aadb";
    private const SGBD_DBUSER = "aadbuser";
    private const SGBD_PASSWD = "@IA847atm";
    private const SGBD_PORT = 3306;

    // Remote
    //private const SGBD_URI = "mysql:host=127.0.0.1";
    //private const SGBD_DBNAME = "aadb";
    //private const SGBD_DBUSER = "aadbuser";
    //private const SGBD_PASSWD = "@IA847atm";
    //private const SGBD_PORT = 3306;

    
    
    private function __construct($dbname = null) {
        /*
          if ($dbname == null) {
          if (self::$connection == null) {
          //self::$connection = new PDO('mysql:host=aadb.mysql.uhserver.com;dbname=aadb', 'aadbuser', '@ia847atm');
          self::$connection = new PDO(self::SGBD_URI . ';dbname=' . self::SGBD_DBNAME, self::SGBD_DBUSER, self::SGBD_PASSWD);
          self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          }
          } elseif (self::$connection == null) {
          self::$instance = new AAConnectDBSQLite($dbname);
          self::$connection = self::$instance->getConnection($dbname);
          }
         * 
         */
        self::$connection = array();
    }
    

    public static function getConnection() {
        return self::$connection;
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new AAConnectDB();
        }
        return self::$instance;
    }

    public function getPort() {
        return self::SGBD_PORT;
    }
    
    public function getDBName() {
        return self::SGBD_DBNAME;
    }

    public function getHost() {
        return explode("=", self::SGBD_URI)[1];
    }

    public function getUser() {
        return self::SGBD_DBUSER;
    }

    public function getPassword() {
        return self::SGBD_PASSWD;
    }

}
