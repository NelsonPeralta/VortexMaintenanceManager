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

        public function GetUserDAO(){
            return $this->userDAO;
        }

        public function GetCompanyDAO(){
            return $this->companyDAO;
        }

        public function GetMemberDAO(){
            return $this->memberDAO;
        }
    }
?>