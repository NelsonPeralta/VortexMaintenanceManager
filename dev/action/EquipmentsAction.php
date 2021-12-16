<?php
    require_once("action/CommonAction.php");

    class EquipmentsAction extends CommonAction{

        protected function executeAction() {
            $data = NULL;
            $companyname = $_SESSION["user"]->GetCompanyName();
            $this->makeglobalconnection();
            $this->makecompanyconnection($companyname);

            return $data;
        }

        function GetEquipments(){
            $req = $this->companydb->prepare("SELECT * FROM Equipments");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetEquipment($equipmentid){
            $req = $this->companydb->prepare("SELECT * FROM Equipments WHERE id='$equipmentid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $equipment = $req->fetch();

            $equipmentDAO = new EquipmentDAO($equipment["id"], $equipment["tag"], $equipment["name"], $equipment["description"]);

            return $equipmentDAO;
        }
    }
?>