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
    <input type="text" placeholder="username" id="register-username-input">
    <input type="password" placeholder="password" id="register-password-input">
    <input type="text" placeholder="email" id="register-email-input">
    <input type="text" placeholder="company" id="register-company-input">
    <button id="register-register-btn" onclick="register()">Register</button>
</body>
<script>
    const register = () =>{

            const usernameValue = document.getElementById("register-username-input").value
            const pwdValue = document.getElementById("register-password-input").value
            const emailValue = document.getElementById("register-email-input").value
            const companyValue = document.getElementById("register-company-input").value

            let formData = new FormData();
            formData.append('service', "register")
            formData.append('username', usernameValue)
            formData.append('password', pwdValue)
            formData.append('email', emailValue)
            formData.append('company', companyValue)

            let erreurs = "";

            if(usernameValue.length <= 0)
                erreurs += "Le Username ne doit pas etre vide\n"
            if(pwdValue.length <= 0)
                erreurs += "Le Mot de Passe ne doit pas etre vide\n"
            if(emailValue.length <= 0)
                erreurs += "Le Courriel ne doit pas etre vide\n"
            if(companyValue.length <= 0)
                erreurs += "Le nom de Compagnie ne doit pas etre vide"

            if(erreurs.length <= 0){


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
                        alert("Enregistrement avec success!")
                        window.location.replace("index.php")
                    }
                })

            }else{
                alert("Erreur: " + erreurs)
            }
        }
</script>
</html>