<?php
require_once('dao/globalconnectioncredentials.php');
    class CompanyConnectionDAO{
        private static $db;

        public static function getConnection($companydbname){
            if(!isset(CompanyConnectionDAO::$db)){
                CompanyConnectionDAO::$db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . $companydbname, DB_USER, DB_PASS);
                CompanyConnectionDAO::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return CompanyConnectionDAO::$db;
        }

        public static function closeConnection(){
            if(isset(CompanyConnectionDAO::$db)){
                CompanyConnectionDAO::$db = null;
            }
        }
    }