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
            <fieldset id="work-order-workers-fieldset" class="align-horizontal">
                <legend>Workers</legend>
                <button id="work-order-add-worker-btn" onclick="addworkerrow()">Add a Worker</button><br>
                <?php 
                    if(isset($_GET["wogid"])){
                        $listofworkers = $action->GetListOfWorkers($_GET["wogid"]);
                        $listofmembers = [];
                        
                        if($listofworkers != NULL){
                            
                            
                            $req = $action->GetMembers();
                            while($row = $req->fetch()){
                                
                                array_push($listofmembers, $row);
                            }
                            
                        
                            
                            for ($x = 0; $x <= count($listofworkers) - 1; $x++) {
                                echo "<select class='work-order-worker-select'>";
                                $workername = $listofworkers[$x]->GetName();
                                $workersurname = $listofworkers[$x]->GetSurname();
                                $workerid = $listofworkers[$x]->GetId();
                                echo "<option value=$workerid>$workersurname $workername</option>";
                                echo "<option value=0>-- None --</option>";
                                
                                for ($y = 0; $y <= count($listofmembers) - 1; $y++){
                                    if($listofmembers[$y]["id"] != $workerid){
                                        $membername = $listofmembers[$y]["name"];
                                        $membersurname = $listofmembers[$y]["surname"];
                                        $memberid = $listofmembers[$y]["id"];
                                        echo "<option value=$memberid>$membersurname $membername</option>";
                                    }
                                }
                                echo "</select>";
                            }
                        }
                    }
                ?>
            </fieldset>

            <fieldset id="work-order-workers-fieldset" class="align-horizontal">
                <legend>Parts</legend>
                <button id="work-order-add-worker-btn" onclick="addPartRow()">Add a Part</button><br>
                <?php 
                    if(isset($_GET["wogid"])){
                        // $listofworkers = $action->GetListOfWorkers($_GET["wogid"]);
                        // $listofmembers = [];
                        
                        // if($listofworkers != NULL){
                            
                            
                        //     $req = $action->GetMembers();
                        //     while($row = $req->fetch()){
                                
                        //         array_push($listofmembers, $row);
                        //     }
                            
                        
                            
                        //     for ($x = 0; $x <= count($listofworkers) - 1; $x++) {
                        //         echo "<select class='work-order-worker-select'>";
                        //         $workername = $listofworkers[$x]->GetName();
                        //         $workersurname = $listofworkers[$x]->GetSurname();
                        //         $workerid = $listofworkers[$x]->GetId();
                        //         echo "<option value=$workerid>$workersurname $workername</option>";
                        //         echo "<option value=0>-- None --</option>";
                                
                        //         for ($y = 0; $y <= count($listofmembers) - 1; $y++){
                        //             if($listofmembers[$y]["id"] != $workerid){
                        //                 $membername = $listofmembers[$y]["name"];
                        //                 $membersurname = $listofmembers[$y]["surname"];
                        //                 $memberid = $listofmembers[$y]["id"];
                        //                 echo "<option value=$memberid>$membersurname $membername</option>";
                        //             }
                        //         }
                        //         echo "</select>";
                        //     }
                        // }
                    }
                ?>
            </fieldset>

            <div>
                <button id="work-order-save-btn" onclick="savewochanges()">Save</button>
                <?php
                    if(isset($_GET["wogid"])){
                        $wogid = $_GET["wogid"];
                        echo "<button id='work-order-delete-btn' onclick=DeleteWorkOrder('$wogid')>Delete</button>";
                        echo "<button id='work-order-close-btn' onclick=CloseWorkOrder('$wogid')>Close</button>";
                    }
                ?>
            </div>
            
    <?php
        }
    ?>
    <script>
        const workersFieldset = document.getElementById("work-order-workers-fieldset")

        const addWorkerRow = () =>{

            let formData = new FormData();
            formData.append('service', "add-worker-row")

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
                console.log("RAW DATA:" + data)
                data = JSON.parse(data)["result"]
                console.log(data)
                DOMLine = data["DOMLine"]


                // foreach row in data["workers"]{
                //     console.log(row)
                // }

                // row = document.createElement(DOMLine)

                selectDOM = document.createElement("select")
                selectDOM.classList.add("work-order-worker-select")
                workersFieldset.appendChild(selectDOM)

                emptyOptionDOM = document.createElement("option")
                emptyOptionDOM.innerHTML = "-- None --"
                emptyOptionDOM.value = 0
                selectDOM.appendChild(emptyOptionDOM)

                for (let i = 0; i < data["workers"].length; i++){
                    console.log(data["workers"][i])

                    worker = data["workers"][i]
                    console.log(worker)


                    optionDOM = document.createElement("option")
                    optionDOM.innerHTML = worker["name"] +  " " + worker["surname"]
                    optionDOM.value = worker["id"]
                    optionDOM.classList.add("work-order-worker-option")

                    selectDOM.appendChild(optionDOM)
                    selectDOM.appendChild(document.createElement("br"))
                }

                // let row = new DOMParser().parseFromString(DOMLine, "text/html")
                // selectDOM.appendChild(row.documentElement)
                // row.body.firstChild
            })
        }

        const addPartRow = () =>{

            let formData = new FormData();
            formData.append('service', "add-part-row")

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
                console.log("RAW DATA:" + data)
                data = JSON.parse(data)["result"]
                console.log(data)


                // DOMLine = data["DOMLine"]

                // selectDOM = document.createElement("select")
                // selectDOM.classList.add("work-order-worker-select")
                // workersFieldset.appendChild(selectDOM)

                // emptyOptionDOM = document.createElement("option")
                // emptyOptionDOM.innerHTML = "-- None --"
                // emptyOptionDOM.value = 0
                // selectDOM.appendChild(emptyOptionDOM)

                // for (let i = 0; i < data["workers"].length; i++){
                //     console.log(data["workers"][i])

                //     worker = data["workers"][i]
                //     console.log(worker)


                //     optionDOM = document.createElement("option")
                //     optionDOM.innerHTML = worker["name"] +  " " + worker["surname"]
                //     optionDOM.value = worker["id"]
                //     optionDOM.classList.add("work-order-worker-option")

                //     selectDOM.appendChild(optionDOM)
                //     selectDOM.appendChild(document.createElement("br"))
                // }
            })
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

            workersDOM = document.getElementsByClassName("work-order-worker-select")
            listOfWorkers = []
            formData.append('listofworkers[]', listOfWorkers)

            for (i = 0; i < workersDOM.length; i++){
                if(workersDOM[i].value != 0)
                    listOfWorkers.push(workersDOM[i].value)
            }
            console.log(listOfWorkers)

            for (var i = 0; i < listOfWorkers.length; i++) {
                formData.append('listofworkers[]', listOfWorkers[i]);
            }

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
                    window.open("work-order-instance.php?wogid=" + wogid) // Creates a new tab with no browsing history
                    close()
                }
            })
        }

        const DeleteWorkOrder = (wogid) =>{
            console.log(wogid)
            let formData = new FormData();
            formData.append("service", "delete-work-order")
            formData.append("wogid", wogid)

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
                    alert("Suppression avec success!")
                    close()
                }
            })
        }

        const CloseWorkOrder = (wogid) =>{
            console.log(wogid)
            let formData = new FormData();
            formData.append("service", "close-work-order")
            formData.append("wogid", wogid)

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
                    alert("Fermeture avec success!")
                    close()
                }
            })
        }
    </script>
</body>
</html>