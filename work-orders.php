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
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <?php
        if(!isset($data["user"])){
            header("Location: index.php");
            exit();
        }else{ include_once("partials/navigation-bar.php");?>
            <button id="new-work-order-btn">New Work Order</button>

            <section id="home-body">
                <?php $req = $action->getWorkOrders(); ?>

                <table id="home-table">
                    <tr>
                        <th>Work Order Id</th>
                        <th>Title</th>
                    </tr>
                    <?php
                        while($row = $req->fetch()){
                            
                            $workOrderId = $row["id"];
                            $givenId = $row["given_id"];
                            echo "<tr id='$workOrderId' class='work-order'> <th>$givenId</th> <th>A WO title</th></tr>";
                        }
                    ?>
                </table>
            </section>
    <?php
        }
    ?>
    <script>
        window.addEventListener('load', e =>{
            document.getElementById("new-work-order-btn").addEventListener("click", newWorkOrder)
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

                window.open("work-order-instance.php?woid=" + clickedDOM.id)
            }
            console.log(clickedDOM)
            //if(elementDessousSouris.parentElement.className == "card")
            //    elementDessousSouris = elementDessousSouris.parentElement
            
        }

        const newWorkOrder = () =>{
            console.log("New Work Order")
            let formData = new FormData();
            formData.append('service', "get-number-of-work-orders")

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
                console.log(JSON.parse(data)["result"]["COUNT(id)"])

                nbWO = JSON.parse(data)["result"]["COUNT(id)"]

                if(nbWO >= 10)
                    alert("You have reached your maximum number of Work Orders")
                else
                    window.open("work-order-instance.php")
            })

        }
    </script>
</body>
</html>