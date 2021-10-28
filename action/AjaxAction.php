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
                }else if($_POST["service"] == "save-or-create-work-order")
                    return $this->saveorcreateworkorder();
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
            $this->makecompanyconnection($_SESSION["user"]->GetCompanyDAO()->GetName());

            $result["error"] = "";

            $newTitle = $_POST["title"];
            $newDes = $_POST["description"];

            $newSup = $_POST["supervisor"];

            $newPri = $_POST["priority"];
            $newSta = $_POST["status"];
            $newEqu = $_POST["equipment"];

            if($newTitle != ""){

                
                if($_POST["wogid"] != "New Work Order"){
                    $wogid = $_POST["wogid"];
                    $result["generated_id"] = $wogid;
                    
                    $req = $this->companydb->prepare("UPDATE work_orders SET title='$newTitle', 
                        description='$newDes', supervisor_member_id='$newSup', priority_id='$newPri', 
                        status_id='$newSta', equipment_id='$newEqu' WHERE generated_id='$wogid';");
                    $req->setFetchMode(PDO::FETCH_ASSOC);
                    $req->execute();
                }else{
                    $result["info"] = "Creating Work Order";
                    
                    $req = $this->companydb->prepare("INSERT INTO `work_orders` (`id`, `generated_id`, `supervisor_id`, `priority_id`, `status_id`, `equipment_id`, `title`, `description`, `date_created`, `date_finished`, `date_start`, `open`) 
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
                }
            }else{
                $result["error"] = "Le titre ne doit pas etre vide";
            }
            return compact("result");
        }
    }
?>