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
            <button id="new-part-btn" onclick="newPart()">New Part</button>

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
    <?php
        }
    ?>
    <script>
        const openPart = (partId) =>{
            console.log("opening part " + partId)
            window.open("part_instance.php?pid=" + partId)
        }

        const newWorkOrder = () =>{
            window.open("work-order-instance.php")
        }
    </script>
</body>
</html>