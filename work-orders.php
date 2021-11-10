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
            <button id="new-work-order-btn" onclick="newWorkOrder()">New Work Order</button>
            <!-- <button id="view-closed-work-orders-btn" onclick="ShowClosedWorkOrders()">View Closed Work Orders</button> -->

            <section id="home-body">
                <?php $req = $action->GetWorkOrders(); ?>

                <table id="home-table">
                    <tr>
                        <th>Work Order Id</th>
                        <th>Title</th>
                    </tr>
                    <?php
                        while($row = $req->fetch()){
                            
                            $workOrderId = $row["id"];
                            $generated_id = $row["generated_id"];
                            $title = $row["title"];
                            echo "<tr id='$generated_id' class='work-order'> <th>$generated_id</th> <th>$title</th></tr>";
                        }
                    ?>
                </table>
            </section>
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
                let formData = new FormData();

                // formData.append('service', "set-work-order")
                // formData.append('work-order-id', clickedDOM.id)

                // fetch("ajax.php", {
                //     method: "POST",
                //     body: formData
                // }).then(response => {
                //     if (response.ok) {
                //         return response.text();
                //     } else {
                //         console.log("REQUEST FAILED, error: " + response.statusText);
                //     }
                // }).then(data => {
                //     console.log(data)
                // })

                window.open("work-order-instance.php?wogid=" + clickedDOM.id)
            }
            console.log(clickedDOM)
            //if(elementDessousSouris.parentElement.className == "card")
            //    elementDessousSouris = elementDessousSouris.parentElement
            
        }

        const newWorkOrder = () =>{
            window.open("work-order-instance.php")
        }
    </script>
</body>
</html>