<?php
    class EquipmentDAO{

        private $id;
        private $tag;
        private $name;
        private $description;

        public function __construct($_id, $_tag, $_name, $_description){
            $this->id = $_id;
            $this->tag = $_tag;
            $this->name = $_name;
            $this->description = $_description;
        }

        public function GetId(){
            return $this->id;
        }

        public function GetTag(){
            return $this->tag;
        }

        public function GetName(){
            return $this->name;
        }

        public function GetDescription(){
            return $this->description;
        }
    }
?>