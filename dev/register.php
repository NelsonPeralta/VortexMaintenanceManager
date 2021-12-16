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
    <div id="register-menu" class="align-horizontal">
        <input type="text" placeholder="name" id="register-name-input">
        <input type="text" placeholder="surname" id="register-surname-input">
        <input type="text" placeholder="username" id="register-username-input">
        <input type="password" placeholder="password" id="register-password-input">
        <input type="text" placeholder="email" id="register-email-input">
        <input type="text" placeholder="company" id="register-company-input">
        <button id="register-register-btn" onclick="register()">Register</button>
    </div>
    <div id="register-working">
        <p>Working...</p>
    </div>
</body>
<script>
    const registermenu = document.getElementById("register-menu")
    const registerworkingtext = document.getElementById("register-working")

    registerworkingtext.style.display = "none"

    const register = () =>{


            const nameValue = document.getElementById("register-name-input").value
            const surnameValue = document.getElementById("register-surname-input").value
            const usernameValue = document.getElementById("register-username-input").value
            const pwdValue = document.getElementById("register-password-input").value
            const emailValue = document.getElementById("register-email-input").value
            const companyValue = document.getElementById("register-company-input").value

            let formData = new FormData();
            formData.append('service', "register")
            formData.append('name', nameValue)
            formData.append('surname', surnameValue)
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

                registermenu.style.display = "none"
                registerworkingtext.style.display = "block"

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
                        registermenu.style.display = "flex"
                        registerworkingtext.style.display = "none"
                    }
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