<?php
    require_once("action/CommonAction.php");

    class InventoryAction extends CommonAction{

        protected function executeAction() {
            $data = NULL;
            $companyname = $_SESSION["user"]->GetCompanyName();
            $this->makeglobalconnection();
            $this->makecompanyconnection($companyname);

            return $data;
        }

        function getInventory(){
            $req = $this->companydb->prepare("SELECT * FROM Parts");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function getPart($partId){
            $req = $this->companydb->prepare("SELECT * FROM Parts WHERE id='$partId'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $part = $req->fetch();

            $partDAO = new PartDAO($part["id"], $part["generated_id"], $part["name"], $part["description"], $part["stock"], $part["price"]);

            return $partDAO;
        }
    }
?>