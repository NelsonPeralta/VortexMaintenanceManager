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
    
    <link rel="icon" href="sprites/vortex_logo.png">
    <?php 
        $employeeId = $_GET["eid"];
        echo  "<title>$employeeId</title>";
        $data = $action->execute();
    ?>
    
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    
</body>
</html>