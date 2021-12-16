<?php
    require_once("dao/GlobalConnectionDAO.php");
    require_once("dao/CompanyConnectionDAO.php");

    // Requires DAOs in order to serialize in $_SESSION
    require_once("dao/UserDAO.php");
    require_once("dao/CompanyDAO.php");
    require_once("dao/MemberDAO.php");
    require_once("dao/PriorityDAO.php");
    require_once("dao/StatusDAO.php");
    require_once("dao/EquipmentDAO.php");
    require_once("dao/PartDAO.php");
    require_once("dao/WorkOrderDAO.php");
    require_once("dao/UserAdaptorDAO.php");
    require_once("dao/WorkOrderAdaptorDAO.php");

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