<?php
    class PartDAO{

        private $id;
        private $generatedId;
        private $name;
        private $description;
        private $stock;
        private $price;

        public function __construct($_id, $_generatedId, $_name, $_description, $_stock, $_price){
            $this->id = $_id;
            $this->generatedId = $_generatedId;
            $this->name = $_name;
            $this->description = $_description;
            $this->stock = $_stock;
            $this->price = $_price;
        }

        public function getId(){
            return $this->id;
        }

        public function getGeneratedId(){
            return $this->generatedId;
        }

        public function getName(){
            return $this->name;
        }

        public function getDescription(){
            return $this->description;
        }

        public function getStock(){
            return $this->stock;
        }

        public function getPrice(){
            return $this->price;
        }
    }
?>