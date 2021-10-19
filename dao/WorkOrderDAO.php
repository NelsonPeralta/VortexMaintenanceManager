<?php
    class WODAO {
        // private $id;
        // private $generated_id;
        // private $title;
        // private $description;

        // private $supervisor_id;

        // private $priority_id;
        // private $status_id;
        // private $equipment_id;

        // private $date_created;
        // private $date_finished;
        // private $date_start;





        public $id;
        public $generated_id;
        public $title;
        public $description;

        public $supervisor_id;

        public $priority_id;
        public $status_id;
        public $equipment_id;

        public $date_created;
        public $date_finished;
        public $date_start;

        public function __construct($_id, $_generated_id, $_title, $_description, $_supervisor_id, $_priority_id, $_status_id, $_equipment_id, $_date_created, $_date_finished, $_date_start)
        {
            $this->id = $_id;
            $this->generated_id = $_generated_id;
            $this->title = $_title;
            $this->description = $_description;

            $this->supervisor_id = $_supervisor_id;

            $this->priority_id = $_priority_id;
            $this->status_id = $_status_id;
            $this->equipment_id = $_equipment_id;

            $this->date_created = $_date_created;
            $this->date_finished = $_date_finished;
            $this->date_start = $_date_start;
        }

        // GETTERS

        public function GetId(){
            return $this->id;
        }

        public function GetGeneratedId(){
            return $this->generated_id;
        }

        public function GetTitle(){
            return $this->title;
        }

        public function GetDescription(){
            return $this->description;
        }

        public function GetSupervisorId(){
            return $this->supervisor_id;
        }

        public function GetPriorityId(){
            return $this->priority_id;
        }

        public function GetStatusId(){
            return $this->status_id;
        }

        public function GetEquipmentId(){
            return $this->equipment_id;
        }
    }