<?php
    class UserAdaptorDAO{

        private $userDAO;
        private $companyDAO;
        private $memberDAO;

        public function __construct($_userDAO, $_companyDAO, $_memberDAO){
            $this->userDAO = $_userDAO;
            $this->companyDAO = $_companyDAO;
            $this->memberDAO = $_memberDAO;
        }

        public function GetEmail(){
            return $this->userDAO->GetEmail();
        }

        public function GetUsername(){
            return $this->userDAO->GetUsername();
        }

        public function GetMemberName(){
            return $this->memberDAO->GetName();
        }

        public function GetMemberSurname(){
            return $this->memberDAO->GetSurname();
        }

        public function GetCompanyName(){
            return $this->companyDAO->GetName();
        }

        public function GetCompanyId(){
            return $this->companyDAO->GetId();
        }
    }
?>