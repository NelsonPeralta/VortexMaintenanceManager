<?php
    class MemberDAO{

        private $id;
        private $name;
        private $surname;
        private $userId;

        public function __construct($_id, $_name, $_surname, $_userId){
            $this->id = $_id;
            $this->name = $_name;
            $this->surname = $_surname;
            $this->userId = $_userId;            
        }

        public function GetId(){
            return $this->id;
        }

        public function GetName(){
            return $this->name;
        }

        public function GetSurname(){
            return $this->surname;
        }

        public function GetUserId(){
            return $this->userId;
        }
    }
?>