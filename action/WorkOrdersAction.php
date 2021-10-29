<?php
    require_once("action/CommonAction.php");

    class WorkOrdersAction extends CommonAction{

        protected function executeAction() {
            $data = NULL;
            $companyname = $_SESSION["user"]->GetCompanyName();
            $this->makecompanyconnection($companyname);

            if(isset($_GET["wogid"])){
                $data["work-order-adaptor"] = $this->GetWorkOrderWithGeneratedId($_GET["wogid"]);
            }

            return $data;
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
            
            $req = $this->companydb->prepare("SELECT * FROM Priorities");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetStatuses(){
            
            $req = $this->companydb->prepare("SELECT * FROM Statuses");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetEquipments(){

            $req = $this->companydb->prepare("SELECT * FROM Equipments");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();

            return $req;
        }

        function GetWorkOrderWithGeneratedId($gid){
            $req = $this->companydb->prepare("SELECT * FROM work_orders WHERE generated_id='$gid'");
            $req->setFetchMode(PDO::FETCH_ASSOC);
            $req->execute();
            $wo = $req->fetch();
            $woDAO = new WODAO($wo["id"], $wo["generated_id"], $wo["title"], $wo["description"] ,$wo["supervisor_member_id"], 
                $wo["priority_id"], $wo["status_id"], $wo["equipment_id"], $wo["date_created"], 
                $wo["date_finished"], $wo["date_start"]);
            
            $supervisorMemberId = $woDAO->GetSupervisorId();
            $priorityId = $woDAO->GetPriorityId();
            $statusId = $woDAO->GetStatusId();
            $equipmentId = $woDAO->GetEquipmentId();

            $supervisorMemberDAO = new MemberDAO(0, 0, 0, 0);
            $priorityDAO = new PriorityDAO(0, 0);
            $statusDAO = new StatusDAO(0, 0);
            $equipmentDAO = new EquipmentDAO(0, 0, 0, 0);

            if((int)$supervisorMemberId > 0){
                $req = $this->companydb->prepare("SELECT * FROM members WHERE id='$supervisorMemberId'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $supervisorMember = $req->fetch();
                $supervisorMemberDAO = new MemberDAO($supervisorMember["id"], 
                    $supervisorMember["name"], $supervisorMember["surname"], $supervisorMember["user_id"]);
            }

            if((int)$priorityId > 0){
                $req = $this->companydb->prepare("SELECT * FROM priorities WHERE id='$priorityId'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $priority = $req->fetch();
                $priorityDAO = new PriorityDAO($priority["id"], $priority["name"]);
            }

            if((int)$statusId > 0){
                $req = $this->companydb->prepare("SELECT * FROM statuses WHERE id='$statusId'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $status = $req->fetch();
                $statusDAO = new StatusDAO($status["id"], $status["name"]);
            }

            if((int)$equipmentId > 0){
                $req = $this->companydb->prepare("SELECT * FROM equipments WHERE id='$equipmentId'");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute();
                $equipment = $req->fetch();
                $equipmentDAO = new EquipmentDAO($equipment["id"], $equipment["tag"], $equipment["name"], $equipment["description"]);
            }

            $woAdaptorDAO = new WorkOrderAdaptorDAO($woDAO, $supervisorMemberDAO, $priorityDAO, $statusDAO, $equipmentDAO);

            return $woAdaptorDAO;
        }
    }
?>