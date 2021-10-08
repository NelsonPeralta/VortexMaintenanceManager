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
        <button id="login-login-btn" class="small-margin">Login</button>
        <button id="login-register-btn" class="small-margin">Register</button>
    </section>
</body>
</html>