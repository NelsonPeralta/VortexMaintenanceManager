<?php
    class CompanyDAO{

        private $id;
        private $name;

        public function __construct($_id, $_name){
            $this->id = $_id;
            $this->name = $_name;
        }

        public function GetId(){
            return $this->id;
        }

        public function GetName(){
            return $this->name;
        }
    }
?>