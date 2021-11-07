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
        $employeeId = $_GET["mid"];
        echo  "<title>$employeeId</title>";
        $data = $action->execute();
    ?>
    
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <div id="register-menu" class="align-horizontal">
        <?php
            $userAdaptorDAO = $action->GetUserAdaptorWithMemberId($employeeId);
            // var_dump($userAdaptorDAO);

            $memberName = $userAdaptorDAO->GetMemberName();
            $memberSurname = $userAdaptorDAO->GetMemberSurname();

            $username = $userAdaptorDAO->GetUsername();
            $email = $userAdaptorDAO->GetEmail();

            echo "<input type='text' placeholder='name' id='name-input' value='$memberName'>";
            echo "<input type='text' placeholder='surname' id='surname-input' value='$memberSurname'>";

            echo "<input type='text' placeholder='username' id='username-input' value='$username'>";
            echo "<input type='password' placeholder='password' id='password-input'>";
            
            echo "<input type='text' placeholder='email' id='email-input' value='$email'>";
        ?>

        <button id="register-register-btn" onclick="Save()">Save</button>
    </div>

    <script>
        const Save = () =>{
            const nameValue = document.getElementById("name-input").value
            const surnameValue = document.getElementById("surname-input").value
            const usernameValue = document.getElementById("username-input").value
            const pwdValue = document.getElementById("password-input").value
            const emailValue = document.getElementById("email-input").value

            let formData = new FormData();
            formData.append('service', "save-member-info")
            formData.append('name', nameValue)
            formData.append('surname', surnameValue)
            formData.append('username', usernameValue)
            formData.append('password', pwdValue)
            formData.append('email', emailValue)

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