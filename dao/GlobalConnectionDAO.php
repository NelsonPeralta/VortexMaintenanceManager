<?php
require_once('dao/globalconnectioncredentials.php');
    class GlobalConnectionDAO{
        private static $db;

        public static function getConnection(){
            if(!isset(GlobalConnectionDAO::$db)){
                GlobalConnectionDAO::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
                GlobalConnectionDAO::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return GlobalConnectionDAO::$db;
        }

        public static function closeConnection(){
            if(isset(GlobalConnectionDAO::$db)){
                GlobalConnectionDAO::$db = null;
            }
        }
    }