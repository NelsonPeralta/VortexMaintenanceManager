<?php
    require_once("action/WorkOrdersAction.php");

	$action = new WorkOrdersAction();
	$data = $action->execute();	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="sprites/vortex_logo.png">
    <?php 
        if(isset($_GET["wogid"])){
            $workOrderId = $_GET["wogid"];
            echo  "<title>$workOrderId</title>";
            $data = $action->execute();
        }else{
            echo  "<title>New Work Order</title>" ;
        }
    ?>
    
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <?php
        if(!isset($data["user"])){
            header("Location: index.php");
            exit();
        }else{ 
            var_dump($data);
            if(isset($_GET["wogid"])){
                $workOrderId = $_GET["wogid"];
                echo  "<h1 id='work-order-generated-id'>$workOrderId</h1>";
            }else{
                echo  "<h1 id='work-order-generated-id'>New Work Order</h1>" ;
            }
        ?>

            <table>
                <tr>
                    <th>
                        <?php $req = $action->GetMembers(); ?>
                        <?php
                        
                            echo "Supervisor: <select id='supervisor-select-element'>";
                            if(isset($data["work-order-adaptor"])){
                                $woAdaptorDAO = $data["work-order-adaptor"];
                                $supervisorId = $woAdaptorDAO->GetSupervisorId();

                                if((int)$woAdaptorDAO->GetSupervisorId() > 0){
                                    $supervisorName = $woAdaptorDAO->GetSupervisorName();
                                    $supervisorSurname = $woAdaptorDAO->GetSupervisorSurname();
                                    echo "<option value='$supervisorId'>$supervisorId - $supervisorName $supervisorSurname</option>";
                                }else
                                    echo "<option value='0'></option>";
                            }else
                                echo "<option value='0'></option>";
                            
                            while($row = $req->fetch()){
                                $employeeId = $row['id'];
                                $name = $row['name'];
                                $surname = $row['surname'];
                                if($supervisorId != $employeeId)
                                    echo "<option value='$employeeId'>$employeeId - $name $surname</option>";
                            }
                        ?>
                        </select>
                    </th>
                    <th>
                        <?php $req = $action->GetEquipments(); ?>
                        <?php

                            echo "Equipment: <select id='equipment-select-element'>";
                            if(isset($data["work-order-adaptor"])){
                                $woAdaptorDAO = $data["work-order-adaptor"];
                                $equipmentId = $data["work-order-adaptor"]->GetEquipmentId();

                                if((int)$woAdaptorDAO->GetEquipmentId() > 0){
                                    $equipmentTag = $woAdaptorDAO->GetEquipmentTag();
                                    $equipmentName = $woAdaptorDAO->GetEquipmentName();
                                    echo "<option value='$equipmentId'>$equipmentTag - $equipmentName</option>";
                                }else
                                        echo "<option value='0'></option>";
                            }else
                                echo "<option value='0'></option>";

                            while($row = $req->fetch()){
                                $_equipmentId = $row['id'];
                                $givenId = $row['tag'];
                                $name = $row['name'];
                                $description = $row['description'];

                                if($equipmentId != $_equipmentId)
                                    echo "<option value='$_equipmentId'>$givenId - $name</option>";
                            }
                        ?>
                        </select>
                    </th>
                    <th>
                        <?php $req = $action->GetStatuses(); ?>
                        <?php
                            $statusId = 0;
                            echo "Status: <select id='status-select-element'>";
                            if(isset($data["work-order-adaptor"])){
                                $woAdaptorDAO = $data["work-order-adaptor"];
                                $statusId = $woAdaptorDAO->GetStatusId();

                                if((int)$woAdaptorDAO->GetStatusId() > 0){
                                    $statusName = $woAdaptorDAO->GetStatusName();
                                    echo "<option value='$statusId'>$statusId - $statusName</option>";
                                }else
                                    echo "<option value='0'></option>";
                            }else
                                echo "<option value='0'></option>";
                                
                            while($row = $req->fetch()){
                                $_statusId = $row['id'];
                                $name = $row['name'];
                                if($statusId != $_statusId)
                                    echo "<option value='$_statusId'>$_statusId - $name</option>";
                            }
                        ?>
                    </th>
                    <th>
                    <th>
                        <?php $req = $action->GetPriorities(); ?>
                        <?php

                            echo "Priority: <select id='priority-select-element'>";
                            if(isset($data["work-order-adaptor"])){
                                $woAdaptorDAO = $data["work-order-adaptor"];
                                $priorityId = $woAdaptorDAO->GetPriorityId();

                                if((int)$woAdaptorDAO->GetPriorityId() > 0){
                                    $priorityName = $woAdaptorDAO->GetPriorityName();
                                    echo "<option value='$priorityId'>$priorityId - $priorityName</option>";
                                }else
                                    echo "<option value='0'></option>";
                            }else
                                echo "<option value='0'></option>";
                            
                            while($row = $req->fetch()){
                                $_priorityId = $row['id'];
                                $name = $row['name'];

                                if($priorityId != $_priorityId)
                                    echo "<option value='$_priorityId'>$_priorityId - $name</option>";
                            }
                        ?>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>Starting Date (TO DO)
                        
                        <input type="date">
                    </th>
                </tr>
            </table>

            <?php //https://stackoverflow.com/questions/55795839/format-user-input-from-textbox-with-javascript-to-hhmmss ?>

            <section>
                <?php 

                    echo "<p>Title</p>";
                    echo "<textarea rows='1' cols='100' id='work-order-instance-title' placeholder='Title'>";

                    if(isset($data["work-order-adaptor"])){
                        $title = $data["work-order-adaptor"]->GetTitle();
                        echo "$title";
                    }
                    echo "</textarea>";

                    echo "<p>Description</p>";
                    echo "<textarea rows='10' cols='100' id='work-order-instance-description' placeholder='Description'>";

                    if(isset($data["work-order-adaptor"])){
                        $description = $data["work-order-adaptor"]->GetDescription();
                        echo "$description";
                    }
                    echo "</textarea>";
                ?>
            </section>

            <div>
                <button id="work-order-save-btn" onclick="savewochanges()">Save</button>
                <button id="work-order-delete-btn">Delete</button>
            </div>
            
    <?php
        }
    ?>
    <script>
        window.addEventListener('load', e =>{
            document.addEventListener("click", clickListener)

        })

        const clickListener = (event) =>{
            const x = event.clientX, y = event.clientY
            let clickedDOM = document.elementFromPoint(x, y)

            if(clickedDOM.tagName == "TH"){
                clickedDOM = clickedDOM.parentElement
            }
            if(clickedDOM.tagName == "TR" && clickedDOM.className == "work-order"){
                window.open("instances/work-order-instance.php")
            }
            console.log(clickedDOM)
            //if(elementDessousSouris.parentElement.className == "card")
            //    elementDessousSouris = elementDessousSouris.parentElement
            
        }

        const savewochanges = () =>{
            wogid = document.getElementById("work-order-generated-id").innerHTML

            newTitle = document.getElementById("work-order-instance-title").value
            newDes = document.getElementById("work-order-instance-description").value
            
            newSup = document.getElementById("supervisor-select-element").value

            newPri = document.getElementById("priority-select-element").value
            newSta = document.getElementById("status-select-element").value
            newEqu = document.getElementById("equipment-select-element").value

            console.log(isNaN(wogid))

            let formData = new FormData();
            formData.append('service', "save-or-create-work-order")
            formData.append("wogid", wogid)

            formData.append("title", newTitle)
            formData.append("description", newDes)

            formData.append("supervisor", newSup)

            formData.append("priority", newPri)
            formData.append("status", newSta)
            formData.append("equipment", newEqu)


            fetch("ajax.php", {
                method: "POST",
                body: formData
            }).then(response => {
                if (response.ok) {
                    return response.text();
                } else {
                    console.log("REQUEST FAILED, error: " + response.statusText);
                }
            }).then(data => {
                console.log(data)
                data = JSON.parse(data)["result"]

                if(data["error"] != "")
                        alert(data["error"])
                else{
                    console.log(data)
                    wogid = data["generated_id"]
                    alert("Enregistrement avec success!" + wogid)
                    // window.open("work-order-instance.php?wogid=" + wogid) // Creates a new tab with no browsing history
                    // close()
                }
            })
        }
    </script>
</body>
</html>