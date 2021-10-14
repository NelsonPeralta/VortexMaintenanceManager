<?php
    require_once("dao/GlobalConnectionDAO.php");
    require_once("dao/CompanyConnectionDAO.php");

    session_start();

    abstract class CommonAction{

        public $connection;
        public $globaldb;
        public $companydb;

        public function execute(){
            $data = $this->executeAction();

            // L'utilisateur est connecter si $_SESSION["user"] est
            // définit (voir loginAction)
            if (isset($_SESSION["user"])) {
                // On réfère l'objet User dans data pour que la vue
                // l'exploite
                $data["user"] = $_SESSION["user"];
            }
            
            return $data;
        }

        protected abstract function executeAction();

        public function makeglobalconnection(){
            $this->connection = new GlobalConnectionDAO();
            $this->globaldb = $this->connection->getConnection();
        }

        public function makecompanyconnection($companydbname){
            $this->connection = new CompanyConnectionDAO();
            $this->companydb = $this->connection->getConnection($companydbname);
        }
    }
?>