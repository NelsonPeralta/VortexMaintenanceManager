<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    
    <link rel="icon" href="sprites/vortex_logo.png">
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <?php include_once("partials/navigation-bar.php"); ?>
    <input type="text" placeholder="email" id="register-email-input">
    <input type="text" placeholder="company" id="register-company-input">
    <input type="password" placeholder="password" id="register-password-input">
    <button id="register-register-btn">Register</button>
</body>
<script>
    const register = () =>{
            const emailValue = document.getElementById("register-email-input").value
            const companyValue = document.getElementById("register-company-input").value
            const pwdValue = document.getElementById("register-password-input").value

            let formData = new FormData();
            formData.append('service', "register")
            formData.append('email', emailValue)
            formData.append('company', companyValue)
            formData.append('password', pwdValue)

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
            })
        }
</script>
</html>