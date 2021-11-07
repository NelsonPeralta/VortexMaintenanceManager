<?php
    require_once("action/EmployeesAction.php");

	$action = new EmployeesAction();
	$data = $action->execute();	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>

    <link rel="stylesheet" href="css/global.css">
</head>
<body>
    <?php
        { include_once("partials/navigation-bar.php");?>

            <section id="home-body">
            <?php $req = $action->GetMembers(); ?>
            <fieldset>
            <legend>Employees</legend>
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Employee</th>
                    </tr>
                    <?php
                        while($row = $req->fetch()){
                            $name = $row["name"];
                            $surname = $row["surname"];
                            $id = $row["id"];
                            echo "<tr><th>$id</th> <th>$surname $name</th>
                                <th><button onclick=OpenMember($id)>View</button></th>
                                <th><button onclick=DeleteMember($id)>Delete</button></th></tr>";
                        }
                        ?>
                </table>
            </fieldset>
            </section>
            <section>
                <fieldset>
                    <legend>New Employee</legend>
                    <input type="text" placeholder="Name" id="new-employee-name-input">
                    <input type="text" placeholder="Surname" id="new-employee-surname-input">
                    <button onclick="AddEmployee()">Add Employee</button>
                </fieldset>
            </section>
        <?php
            }
        ?>
    <script>
        const AddEmployee = () =>{
            console.log("Add Employee Function")

            newEmployeeNameValue = document.getElementById("new-employee-name-input").value
            newEmployeeSurnameValue = document.getElementById("new-employee-surname-input").value

            if(newEmployeeNameValue.length >0 && newEmployeeSurnameValue.length > 0){
                let formData = new FormData();
                formData.append('service', "add-new-employee")
                formData.append('name', newEmployeeNameValue)
                formData.append('surname', newEmployeeSurnameValue)

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
                    alert("Employee added successfully")
                    location.reload()
                })
            }else
                alert("Both fields must be filled to add new employee")
        }

        const OpenMember = (memberid) =>{
            console.log("Open Memeber " + memberid)

            window.open("employee-instance.php?mid=" + memberid)
        }

        const DeleteMember = (memberid) =>{
            console.log("Delete member " + memberid)

                let formData = new FormData();
                formData.append('service', "delete-member")
                formData.append('id', memberid)

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
                    alert("Employee deleted successfully")
                    location.reload()
                })
        }
    </script>
</body>
</html>