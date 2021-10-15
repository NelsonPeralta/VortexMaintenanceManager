<?php
    require_once("action/CommonAction.php");

    class WorkOrdersAction extends CommonAction{

        protected function executeAction() {
            $companyname = $_SESSION["user"]->GetCompanyDAO()->GetName();
            $this->makecompanyconnection($companyname);
            return;
        }

        function GetWorkOrders(){
            $req = $this->companydb->prepare("SELECT * FROM work_orders");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetMembers(){
            $req = $this->companydb->prepare("SELECT * FROM Members");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetPriorities(){
            
            $req = $this->companydb->prepare("SELECT id, name FROM Priorities");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetStatuses(){
            
            $req = $this->companydb->prepare("SELECT id, name FROM Statuses");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetEquipments(){

            $req = $this->companydb->prepare("SELECT id, tag, name FROM Equipments");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }
    }
?>