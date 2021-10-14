<?php
    require_once("action/CommonAction.php");

    class WorkOrdersAction extends CommonAction{

        protected function executeAction() {
            return;
        }

        function getWorkOrders(){
            $company = $_SESSION["user"]->getCompany();
            $req = $this->companydb->prepare("SELECT id, given_id FROM Work_Orders WHERE company='$company'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }
    }
?>