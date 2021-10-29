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

        public function GetCompanyName(){
            return $this->companyDAO->GetName();
        }
    }
?>