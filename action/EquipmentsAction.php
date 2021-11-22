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

        function GetUserAdaptorWithMemberId($memberid){
            $req = $this->companydb->prepare("SELECT * FROM Members WHERE id='$memberid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $member = $req->fetch();

            $memberDAO = new MemberDAO($member["id"], $member["name"], $member["surname"], $member["user_id"]);
            $userid = $member["user_id"];

            $req = $this->globaldb->prepare("SELECT * FROM users WHERE id='$userid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $user = $req->fetch();
            $userDAO = new UserDAO(0, "", "", "");
            $companyDAO = new CompanyDAO(0, "");

            if($user){
                $userDAO = new UserDAO($user["id"], $user["username"], $user["email"], $user["company"]);
                
                $companyid = $user["company"];
    
                $req = $this->globaldb->prepare("SELECT * FROM companies WHERE id='$companyid'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $company = $req->fetch();
                $companyDAO = new CompanyDAO($company["id"], $company["name"]);
            }

            $UserAdaptorDAO = new UserAdaptorDAO($userDAO, $companyDAO, $memberDAO);

            return $UserAdaptorDAO;
        }
    }
?>