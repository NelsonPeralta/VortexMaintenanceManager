<?php
    require_once("action/CommonAction.php");
    require_once("dao/globalconnectioncredentials.php");
    require_once("dao/UserDAO.php");
    require_once("dao/CompanyDAO.php");
    require_once("dao/MemberDAO.php");
    require_once("dao/UserAdaptorDAO.php");

    class AjaxAction extends CommonAction {
        
        protected function executeAction() {
            if(isset($_POST["service"])){
                if($_POST["service"] == "register"){
                    return $this->register();
                }else if($_POST["service"] == "login"){
                    return $this->login();
                }else if($_POST["service"] == "logout"){
                    return $this->logout();
                }else if($_POST["service"] == "save-or-create-work-order"){
                    return $this->saveorcreateworkorder();
                }else if($_POST["service"] == "add-worker-row"){
                    return $this->GetListOfMembers();
                }else if($_POST["service"] == "add-new-employee"){
                    return $this->AddNewEmployee();
                }else if($_POST["service"] == "delete-member"){
                    return $this->DeleteMember();
                }else if($_POST["service"] == "save-member-info"){
                    return $this->SaveMemberInfo();
                }else if($_POST["service"] == "delete-work-order"){
                    return $this->DeleteWorkOrder();
                }else if($_POST["service"] == "close-work-order"){
                    return $this->CloseWorkOrder();
                }else if($_POST["service"] == "add-new-equipment"){
                    return $this->AddNewEquipment();
                }else if($_POST["service"] == "delete-equipment"){
                    return $this->DeleteEquipment();
                }
            }
        }

        function register(){
            $this->makeglobalconnection();
            $result["error"] = "";

            $username = $_POST["username"];
            $email = $_POST["email"];
            $company = $_POST["company"];
            $password = hash('sha512', $_POST["password"]);
            // $hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
            
            try{
                $this->globaldb->beginTransaction();
                $req = $this->globaldb->prepare("INSERT INTO companies (name) VALUES('$company')");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                
                
            }catch (PDOException $e){
                $result["error"] = "Compagnie existe deja";
            }
            
            try{
                $req = $this->globaldb->prepare("INSERT INTO users (username, email, password, company) 
                    VALUES('$username', '$email', '$password', (SELECT id FROM companies WHERE name='$company'))");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();

                
            }catch (PDOException $e){
                $result["error"] = "Le username ou le email est deja pris";
            }
            
            if($result["error"] == ""){
                $this->globaldb->commit();
                $companydbname = COMPANY_DATABASE_NAME_PREFIX . $company;

                $req = $this->globaldb->prepare("SELECT id FROM users WHERE username='$username'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $userid = $req->fetch();
                $userid = $userid["id"];

                $req = $this->globaldb->prepare("CREATE DATABASE $companydbname");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();

                $this->makecompanyconnection($company);

                $fichier = fopen("scripts/companydb_creation.txt", "r");
                $textecreation = fread($fichier,filesize("scripts/companydb_creation.txt"));
                fclose($fichier);

                $req = $this->companydb->prepare($textecreation);
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();

                $membername = $_POST["name"];
                $membersurname = $_POST["surname"];
                $req = $this->companydb->prepare("INSERT INTO members (name, surname, user_id) 
                    VALUES ('$membername', '$membersurname', '$userid')");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
            }
            else
                $this->globaldb->rollBack();
            
            return compact("result");
        }

        function login(){
            $this->makeglobalconnection();
            $result["error"] = "";

            $username = $_POST["username"];
            $password = $_POST["password"];
            $password = hash('sha512', $_POST["password"]);

            $req = $this->globaldb->prepare("SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $user_req_res = $req->fetch();

            if(!$user_req_res){
                $result["error"] = "Aucun user avec ces informations";
            }else{
                $result["info"] = $user_req_res;
                $userdao = new UserDAO($user_req_res["id"], $user_req_res["username"], $user_req_res["email"], $user_req_res["company"]);
                
                $companyid = $user_req_res["company"];

                $req = $this->globaldb->prepare("SELECT * FROM companies WHERE id='$companyid' LIMIT 1");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $company_req_res = $req->fetch();
                $companydao = new CompanyDAO($company_req_res["id"], $company_req_res["name"]);
                

                $this->makecompanyconnection($companydao->GetName());
                $userId = $userdao->GetId();
                
                $req = $this->companydb->prepare("SELECT * FROM members WHERE user_id='$userId' LIMIT 1");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $member_req_res = $req->fetch();
                $memberdao = new MemberDAO($member_req_res["id"], $member_req_res["name"], $member_req_res["surname"], $member_req_res["user_id"]);
                
                $useradaptordao = new UserAdaptorDAO($userdao, $companydao, $memberdao);
                $_SESSION["user"] = $useradaptordao;

                $result["user adaptor"] = $useradaptordao;
                // $_SESSION["companyname"] = $companydao->GetName();
            }

            return compact("result");
        }

        function logout(){
            session_unset();
            session_destroy();

            $result["error"] = "";
            return compact("result");
        }

        function saveorcreateworkorder(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $result["error"] = "";

            $newTitle = $_POST["title"];
            $newDes = $_POST["description"];

            $newSup = $_POST["supervisor"];

            $newPri = $_POST["priority"];
            $newSta = $_POST["status"];
            $newEqu = $_POST["equipment"];
            $listofworkers = $_POST["listofworkers"];

            
            if($newTitle != ""){
                
                
                if($_POST["wogid"] != "New Work Order"){
                    $wogid = $_POST["wogid"];
                    $result["generated_id"] = $wogid;

                    // $req = $this->companydb->prepare("SELECT id FROM work_orders WHERE generated_id='$generated_id';");
                    // $req->setFetchMode(PDO::FETCH_ASSOC);
                    // $req->execute();        
                    // $woid = $req->fetch();
                    
                    
                    $req = $this->companydb->prepare("UPDATE work_orders SET title='$newTitle', 
                        description='$newDes', supervisor_member_id='$newSup', priority_id='$newPri', 
                        status_id='$newSta', equipment_id='$newEqu' WHERE generated_id='$wogid';");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();

                    $this->UpdateWorkers($wogid, $listofworkers);
                }else{
                    $result["info"] = "Creating Work Order";
                    
                    $req = $this->companydb->prepare("INSERT INTO `work_orders` (`id`, `generated_id`, `supervisor_member_id`, `priority_id`, `status_id`, `equipment_id`, `title`, `description`, `date_created`, `date_finished`, `date_start`, `open`) 
                    VALUES (NULL, NULL, '$newSup', '$newPri', '$newSta', '$newEqu', '$newTitle', '$newDes',curdate(), NULL, NULL, 1);");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();
                    
                    $req = $this->companydb->prepare("SELECT LAST_INSERT_ID();");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();
                    $req = $req->fetch();
                    $woid = $req["LAST_INSERT_ID()"];
                    
                    $this_year = date("Y");
                    $new_id = str_pad($woid, 7, "0", STR_PAD_LEFT);
                    $generated_id = $this_year . "-" . $new_id;
                    
                    $req = $this->companydb->prepare("UPDATE work_orders SET generated_id='$generated_id' WHERE id='$woid';");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();

                    $result["generated_id"] = $generated_id;

                    $this->UpdateWorkers($generated_id, $listofworkers);
                }
            }else{
                $result["error"] = "Le titre ne doit pas etre vide";
            }
            return compact("result");
        }

        function GetListOfMembers(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $req = $this->companydb->prepare("SELECT * FROM members;");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            $listofworkers = [];
            $DOMLine = "";
            while($row = $req->fetch()){
                array_push($listofworkers, $row);

                // $workerId = $row["id"];
                // $DOMLine .= "<option>$workerId</option>";
            }

            $result["workers"] = $listofworkers;
            $result["DOMLine"] = $DOMLine;
            $result["service"] = "Add Worker Row";

            return compact("result");
        }

        function UpdateWorkers($generated_id, $listofworkers){
            $req = $this->companydb->prepare("DELETE FROM work_orders_x_workers WHERE 
                        work_order_id=(SELECT id FROM work_orders WHERE generated_id='$generated_id');");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            for ($x = 0; $x <= count($listofworkers) - 1; $x++) {
                $tempWorkerId = $listofworkers[$x];
                if(intval($tempWorkerId) > 0){
                    $req = $this->companydb->prepare("INSERT INTO work_orders_x_workers(work_order_id, worker_id) 
                        VALUES ((SELECT id FROM work_orders WHERE generated_id='$generated_id'), '$tempWorkerId');");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();

                }
            }
        }

        function AddNewEmployee(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $result["error"] = "";

            $name = $_POST["name"];
            $surname = $_POST["surname"];

            $req = $this->companydb->prepare("INSERT INTO members (name, surname) VALUES('$name', '$surname')");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            $req = $this->companydb->prepare("SELECT * FROM members WHERE name='$name' AND surname='$surname'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $result["newmemberinfo"] = $req->fetch();

            return compact("result");
        }

        function DeleteMember(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());
            $this->makeglobalconnection();

            $result["error"] = "";

            $memberid = $_POST["id"];
            $userid = 0;

            $req = $this->companydb->prepare("SELECT user_id FROM members WHERE id='$memberid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $userid = $req->fetch();

            $req = $this->companydb->prepare("DELETE FROM members WHERE 
                id='$memberid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            $req = $this->globaldb->prepare("DELETE FROM users WHERE id='$userid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
        }

        function SaveMemberInfo(){
            $this->makeglobalconnection();
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $result["error"] = "";

            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $username = $_POST["username"];
            $password = hash('sha512', $_POST["password"]);
            $email = $_POST["email"];
            $companyid = $_SESSION["user"]->GetCompanyId();
            
            $req = $this->companydb->prepare("UPDATE members 
                SET name='$name', surname='$surname' 
                WHERE name='$name' AND surname='$surname';");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            $req = $this->companydb->prepare("SELECT user_id FROM members WHERE name='$name' AND surname='$surname';");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $userid = $req->fetch()["user_id"];

            $result["userid"] = $userid;

            if((int)$userid == 0){
                try{
                    $req = $this->globaldb->prepare("INSERT INTO users (username, email, password, company) 
                    VALUES('$username', '$email', '$password', '$companyid')");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();
                   
                    $req = $this->globaldb->prepare("SELECT LAST_INSERT_ID();");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();
                    $req = $req->fetch();
                    $uid = $req["LAST_INSERT_ID()"];
    
                    $req = $this->companydb->prepare("UPDATE members 
                    SET user_id='$uid'
                    WHERE name='$name' AND surname='$surname';");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();

                }catch (PDOException $e){
                    $result["error"] = "Ce nom d'utilisateur ou email est deja pris";
                    $this->globaldb->rollBack();
                }
            }else{
                $req = $this->globaldb->prepare("UPDATE users 
                    SET username='$username', email='$email', password='$password', company='$companyid'
                    WHERE id='$userid';");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
            }

            return compact("result");
        }

        function DeleteWorkOrder(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $wogid = $_POST["wogid"];
            $result["error"] = "";
            $result["service"] = "Delete work order $wogid";


            // $req = $this->companydb->prepare("UPDATE work_orders 
            //         SET open='0'
            //         WHERE generated_id='$wogid';");
            //     $req->setFetchMode(PDO::FETCH_ASSOC);
            //     $req->execute();

            $req = $this->companydb->prepare("DELETE FROM work_orders 
                WHERE generated_id='$wogid';");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return compact("result");
        }

        function CloseWorkOrder(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $wogid = $_POST["wogid"];
            $result["error"] = "";
            $result["service"] = "Closing work order $wogid";


            $req = $this->companydb->prepare("UPDATE work_orders 
                    SET open=0
                    WHERE generated_id='$wogid';");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return compact("result");
        }

        function AddNewEquipment(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $result["error"] = "";

            $name = $_POST["name"];
            $tag = $_POST["tag"];
            $description = $_POST["description"];

            try{
                $req = $this->companydb->prepare("INSERT INTO Equipments (name, tag, description) VALUES('$name', '$tag', '$description')");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
    
                $req = $this->companydb->prepare("SELECT * FROM Equipments WHERE tag='$tag'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $result["new_equipment_info"] = $req->fetch();

            }catch (PDOException $e){
                $result["error"] = "Tag already in use";
            }

            return compact("result");
        }

        function DeleteEquipment(){
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyName());

            $result["error"] = "";

            $equipmentid = $_POST["id"];

            $req = $this->companydb->prepare("DELETE FROM Equipments WHERE 
                id='$equipmentid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
        }
    }
?>