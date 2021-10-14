<?php
    require_once("action/CommonAction.php");
    require_once("dao/globalconnectioncredentials.php");
    include_once("dao/UserDAO.php");

    class AjaxAction extends CommonAction {
        
        protected function executeAction() {
            if(isset($_POST["service"])){
                if($_POST["service"] == "register"){
                    return $this->register();
                }else if($_POST["service"] == "login"){
                    return $this->login();
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
                $result["error"] = "Database existe deja";
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

                $req = $this->globaldb->prepare("CREATE DATABASE $companydbname");
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
            $req_res = $req->fetch();

            if(!$req_res){
                $result["error"] = "Aucun user avec ces informations";
            }else{
                $result["info"] = $req_res;
                $userdao = new UserDAO($req_res["id"], $req_res["username"], $req_res["email"], $req_res["company"]);
                $_SESSION["user"] = $userdao;
            }

            return compact("result");
        }
    }
?>