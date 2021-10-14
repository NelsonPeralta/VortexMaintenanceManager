<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/global.css">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    <?php include_once("partials/navigation-bar.php"); ?>
    <section class="align-horizontal">
        <input type="text" placeholder="Username" id="login-username-input" class="small-margin">
        <input type="password" placeholder="Password" id="login-password-input" class="small-margin">
        <button id="login-login-btn" class="small-margin" onclick="login()">Login</button>
    </section>
</body>
<script>
    const login = () =>{
            const userValue = document.getElementById("login-username-input").value
            const pwdValue = document.getElementById("login-password-input").value

            let erreurs = "";

            if(userValue.length <= 0)
                erreurs += "Le Username ne doit pas etre vide\n"
            if(pwdValue.length <= 0)
                erreurs += "Le Mot de Passe ne doit pas etre vide\n"

            console.log("asdas")
            if(erreurs.length <= 0){
                let formData = new FormData();
                formData.append('service', "login")
                formData.append('username', userValue)
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
                    data = JSON.parse(data)["result"]
                    console.log(data)

                    if(data["error"] != "")
                        alert(data["error"])
                    else{
                        alert("Login avec success!")
                        window.location.replace("index.php")
                    }
                })

            }else{
                alert("Erreur: " + erreurs)
            }
        }
</script>
</html>