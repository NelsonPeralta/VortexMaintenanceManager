<?php
    class UserDAO{

        private $id;
        private $username;
        private $email;
        private $companyId;

        public function __construct($_id, $_username, $_email, $_companyId){
            $this->id = $_id;
            $this->username = $_username;
            $this->email = $_email;
            $this->companyId = $_companyId;            
        }

        public function GetId(){
            return $this->id;
        }

        public function GetUsername(){
            return $this->username;
        }

        public function GetEmail(){
            return $this->email;
        }

        public function GetCompanyId(){
            return $this->companyId;
        }
    }
?>