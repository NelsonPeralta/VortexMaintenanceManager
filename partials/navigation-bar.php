<section id="navigation-bar">
    <div><a href="index.php"><img src="sprites/vortex_logo.png" alt="vortex_logo" id="navigation-bar-vortex-logo"></a></div>
    <div id="navigation-bar-right-side">
        <?php
            if(!isset($data["user"])){ ?>
                <button id="navigation-bar-register-btn" onclick="GoToRegisterPage()">Register</button>
                |
                <button id="navigation-bar-login-btn" onclick="GoToLoginPage()">Login</button>
        <?php
            }else{?>
                <button id="navigation-bar-work-orders-btn" onclick="GoToWorkOrders()">Work Orders</button>
                <button id="navigation-bar-employees-btn" onclick="GoToEmployees()">Employes</button>
                <button id="navigation-bar-equipments-btn" onclick="GoToEquipments()">Equipments</button>
                |
                <button id="navigation-bar-logout-btn" onclick="Logout()">Logout</button>
        <?php
            }
        ?>
    </div>
</section>

<script>
    const GoToLoginPage = () =>{
        window.location.replace("login.php")
    }

    const GoToRegisterPage = () =>{
        window.location.replace("register.php")
    }

    const GoToWorkOrders = () =>{
        window.location.replace("work-orders.php")
    }

    const GoToEmployees = () =>{
        window.location.replace("employees.php")
    }

    const GoToEquipments = () =>{
        window.location.replace("equipments.php")
    }

    const Logout = () =>{
        let formData = new FormData();
        formData.append('service', "logout")

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