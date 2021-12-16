<?php
    class WorkOrderAdaptorDAO{

        private $woDAO;
        private $supervisorMemberDAO;
        private $priorityDAO;
        private $statusDAO;
        private $equipmentDAO;

        public function __construct($_woDAO, $_supervisorMemberDAO, $_priorityDAO, $_statusDAO, $_equipmentDAO){
            $this->woDAO = $_woDAO;
            $this->supervisorMemberDAO = $_supervisorMemberDAO;
            $this->priorityDAO = $_priorityDAO;
            $this->statusDAO = $_statusDAO;
            $this->equipmentDAO = $_equipmentDAO;
        }

        // ---------------------------------------
        // ----- GETTERS WorkOrderDAO -----
        public function GetTitle(){
            return $this->woDAO->GetTitle();
        }

        public function GetDescription(){
            return $this->woDAO->GetDescription();
        }
        // ----------------- FIN -----------------
        // ---------------------------------------

        // ---------------------------------------
        // ----- GETTERS SupervisorMemberDAO -----
        public function GetSupervisorId(){
            return $this->supervisorMemberDAO->GetId();
        }

        public function GetSupervisorName(){
            return $this->supervisorMemberDAO->GetName();
        }

        public function GetSupervisorSurname(){
            return $this->supervisorMemberDAO->GetSurname();
        }
        // ----------------- FIN -----------------
        // ---------------------------------------

        // ---------------------------------------
        // ----- GETTERS EquipmentDAO -----
        public function GetEquipmentId(){
            return $this->equipmentDAO->GetId();
        }

        public function GetEquipmentTag(){
            return $this->equipmentDAO->GetTag();
        }

        public function GetEquipmentName(){
            return $this->equipmentDAO->GetName();
        }
        // ----------------- FIN -----------------
        // ---------------------------------------
        
        // ---------------------------------------
        // ----- GETTERS StatusDAO -----
        public function GetStatusId(){
            return $this->statusDAO->GetId();
        }

        public function GetStatusName(){
            return $this->statusDAO->GetName();
        }
        // ----------------- FIN -----------------
        // ---------------------------------------

        // ---------------------------------------
        // ----- GETTERS PriorityDAO -----
        public function GetPriorityId(){
            return $this->priorityDAO->GetId();
        }

        public function GetPriorityName(){
            return $this->priorityDAO->GetName();
        }
        // ----------------- FIN -----------------
        // ---------------------------------------
    }
?>