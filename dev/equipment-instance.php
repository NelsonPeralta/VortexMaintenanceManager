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
    
    <link rel="icon" href="sprites/vortex_logo.png">
    <?php 
        $equipmentId = $_GET["eid"];
        echo  "<title>$equipmentId</title>";
        $data = $action->execute();
    ?>
    
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <div id="register-menu" class="align-horizontal">
        <?php
            $equipmentDAO = $action->GetEquipment($equipmentId);

            $equipmentName = $equipmentDAO->GetName();
            $equipmentTag = $equipmentDAO->GetTag();
            $equipmentDescription = $equipmentDAO->GetDescription();

            echo "<input type='text' placeholder='name' id='name-input' value='$equipmentName'>";
            echo "<input type='text' placeholder='tag' id='tag-input' value='$equipmentTag'>";
            echo "<input type='text' placeholder='description' id='description-input' value='$equipmentDescription'>";
        ?>

        <button id="register-register-btn" onclick="Save()">Save</button>
    </div>

    <script>
        const originalTag = document.getElementById("tag-input").value
        const Save = () =>{
            const nameValue = document.getElementById("name-input").value
            const tagValue = document.getElementById("tag-input").value
            const descriptionValue = document.getElementById("description-input").value

            let formData = new FormData();
            formData.append('service', "save-equipment-info")
            formData.append('name', nameValue)
            formData.append('tag', tagValue)
            formData.append('original_tag', originalTag)
            formData.append('description', descriptionValue)

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

                if(data["error"] != ""){

                    alert(data["error"])
                }
                else{
                    alert("Enregistrement avec success!")
                    location.reload()
                }
            })
        }
    </script>
</body>
</html>