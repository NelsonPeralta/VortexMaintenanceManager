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
    
    <link rel="icon" href="sprites/vortex_logo.png">
    <?php 
        $partId = $_GET["pid"];
        echo  "<title>$partId</title>";
        $data = $action->execute();
    ?>
    
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <div id="register-menu" class="align-horizontal">
        <?php
            $partDAO = $action->getPart($partId);
            var_dump($partDAO);

            $partName = $partDAO->getName();
            $partGeneratedId = $partDAO->getGeneratedId();
            $partDescription = $partDAO->getDescription();
            $partStock = $partDAO->getStock();
            $partPrice = $partDAO->getPrice();

            ?>
            <fieldset>
                <legend id="generated-part-id-legend" ><?php echo  $partGeneratedId?></legend>
                <div>
                    <?php
                        echo "Name: <input type='text' placeholder='name' id='name-input' value='$partName'><br>";
                        echo "Description: <br><textarea rows='10' cols='100' style='resize: none;' placeholder='description' id='description-input'>$partDescription</textarea><br>";
                        echo "Stock: <input type='text' placeholder='stock' id='stock-input' value='$partStock'><br>";
                        echo "Price: <input type='text' placeholder='price' id='price-input' value='$partPrice'> $";
                    ?>
                </div>
            </fieldset>

        </div>
    <div>
            
            <button onclick="Save()">Save</button>
            <button onclick="Delete()">Delete</button>
    </div>

    <script>
        const generatedId = document.getElementById("generated-part-id-legend").innerHTML
        const Save = () =>{
            const nameValue = document.getElementById("name-input").value
            const descriptionValue = document.getElementById("description-input").value
            const stockValue = document.getElementById("stock-input").value
            const priceValue = document.getElementById("price-input").value

            let formData = new FormData();
            formData.append('service', "save-part-info")
            formData.append('generatedId', generatedId)
            formData.append('name', nameValue)
            formData.append('description', descriptionValue)
            formData.append('stock', stockValue)
            formData.append('price', priceValue)

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

        const Delete = () =>{
            let formData = new FormData();
            formData.append('service', "delete-part")
            formData.append('generatedId', generatedId)

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
                    alert("Suppression avec success!")
                    close()
                }
            })
        }
    </script>
</body>
</html>