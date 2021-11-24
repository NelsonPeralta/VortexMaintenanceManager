<?php
    require_once("action/InventoryAction.php");

	$action = new InventoryAction();
	$data = $action->execute();	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Orders</title>
    
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="sprites/vortex_logo.png">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <?php
        if(!isset($data["user"])){
            header("Location: index.php");
            exit();
        }else{ include_once("partials/navigation-bar.php");?>
            <section id="home-body">
                <?php $req = $action->getInventory(); ?>

                <table id="home-table">
                    <tr>
                        <th>Part Id</th>
                        <th>Name</th>
                    </tr>
                    <?php
                        while($row = $req->fetch()){
                            
                            $partId = $row["id"];
                            $generatedId = $row["generated_id"];
                            $name = $row["name"];
                            echo "<tr id='$generatedId' class='work-order'> <th onclick='openPart($partId)'>$generatedId</th> <th>$name</th></tr>";
                        }
                    ?>
                </table>
            </section>
        <section>
            <fieldset>
                <legend>New Part</legend>
                <input type="text" placeholder="Name" id="new-part-name-input"><br>
                <textarea placeholder="Description" id="new-part-description-input" rows='10' cols='100'></textarea><br>
                <input type="text" placeholder="Stock" id="new-part-stock-input"><br>
                <input type="text" placeholder="Price" id="new-part-price-input"><br>
                <button id="new-part-btn" onclick="newPart()">New Part</button>

            </fieldset>
        </section>
    <?php
        }
    ?>
    <script>
        const openPart = (partId) =>{
            console.log("opening part " + partId)
            window.open("part_instance.php?pid=" + partId)
        }

        const newPart = () =>{
            newPartNameValue = document.getElementById("new-part-name-input").value
            newPartDescriptionValue = document.getElementById("new-part-description-input").value
            newPartStockValue = document.getElementById("new-part-stock-input").value
            newPartPriceValue = document.getElementById("new-part-price-input").value

            let formData = new FormData();
            formData.append('service', "add-new-part")
            formData.append('name', newPartNameValue)
            formData.append('description', newPartDescriptionValue)
            formData.append('stock', newPartStockValue)
            formData.append('price', newPartPriceValue)

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
                data = JSON.parse(data)["result"]

                if(data["error"] != "")
                        alert("ERROR: " + data["error"])
                else{
                    alert("Enregistrement d'une nouvelle piece avec success!")
                }
            })
        }
    </script>
</body>
</html>