<?php
    require_once("action/CommonAction.php");

    class EmployeesAction extends CommonAction{

        protected function executeAction() {
            $data = NULL;
            $companyname = $_SESSION["user"]->GetCompanyName();
            $this->makecompanyconnection($companyname);

            return $data;
        }

        function GetMembers(){
            $req = $this->companydb->prepare("SELECT * FROM Members");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }
    }
?>