<?php
    require_once("action/EquipmentsAction.php");

	$action = new EquipmentsAction();
	$data = $action->execute();	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipments</title>

    <link rel="stylesheet" href="css/global.css">
</head>
<body>
    <?php
        { include_once("partials/navigation-bar.php");?>

            <section id="home-body">
            <?php $req = $action->GetEquipments(); ?>
            <fieldset>
            <legend>Equipments</legend>
                <table>
                    <tr>
                        <th>Tag</th>
                        <th>equipment</th>
                    </tr>
                    <?php
                        while($row = $req->fetch()){
                            $name = $row["name"];
                            $id = $row["id"];
                            $tag = $row["tag"];
                            echo "<tr><th>$tag</th> <th>$name</th>
                                <th><button onclick=OpenEquipment($id)>View</button></th>
                                <th><button onclick=DeleteEquipment($id)>Delete</button></th></tr>";
                        }
                        ?>
                </table>
            </fieldset>
            </section>
            <section>
                <fieldset>
                    <legend>New Equipment</legend>
                    <!-- <div class="align-horizontal"> -->

                        <input type="text" placeholder="Name" id="new-equipment-name-input"><br>
                        <input type="text" placeholder="Tag" id="new-equipment-tag-input"><br>
                        <textarea placeholder="Description" id="new-equipment-description-input" rows='10' cols='100'></textarea><br>
                        <button onclick="AddEquipment()">Add Equipment</button>
                    <!-- </div> -->
                </fieldset>
            </section>
        <?php
            }
        ?>
    <script>
        const AddEquipment = () =>{
            console.log("Add equipment Function")

            newequipmentNameValue = document.getElementById("new-equipment-name-input").value
            newequipmentTagValue = document.getElementById("new-equipment-tag-input").value
            newequipmentDescriptionValue = document.getElementById("new-equipment-description-input").value

            if(newequipmentNameValue.length >0 && newequipmentTagValue.length > 0){
                let formData = new FormData();
                formData.append('service', "add-new-equipment")
                formData.append('name', newequipmentNameValue)
                formData.append('tag', newequipmentTagValue)
                formData.append('description', newequipmentDescriptionValue)

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
                    alert("equipment added successfully")
                    location.reload()
                })
            }else
                alert("Both fields must be filled to add new equipment")
        }

        const OpenEquipment = (memberid) =>{
            console.log("Open Memeber " + memberid)

            window.open("equipment-instance.php?eid=" + memberid)
        }

        const DeleteEquipment = (memberid) =>{
            console.log("Delete member " + memberid)

                let formData = new FormData();
                formData.append('service', "delete-equipment")
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
                    data = JSON.parse(data)["result"]

                    if(data["error"] != "")
                            alert(data["error"])
                    else{
                        alert("Equipment deleted successfully")
                        location.reload()
                    }
                })
        }
    </script>
</body>
</html>