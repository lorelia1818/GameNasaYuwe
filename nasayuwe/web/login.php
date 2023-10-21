<?php 
    session_start();
    if (isset($_POST['SignIn'])) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
    }
?>

<style>
    .input-group-prepend span{
        width: 40px;
        background-color: #C00000;
        color: white;
        border:0 !important;
    }
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Iniciar Sesión</title>
        <link href="/nasayuwe/lib_form/css_login/maxcdn.bootstrapcdn.com_bootstrap_4.1.1_css_bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>
    <body>
        <section style="background-color: #3d6bbd;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100" >
                    <div class="col col-xl-10" >
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row">
                                <div class="col-lg-5 d-none d-md-block" style="text-align:center;position: relative;transform: translateY(0%);">
                                <img src="/nasayuwe/images/escudo.jpeg"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;top: 20%; position: relative;" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-5 text-black">
                                        <form id="frmLogin" method="POST" action="/nasayuwe/php/login.php">
                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                                <span class="h1 fw-bold mb-0">&nbsp;Iniciar Sesión</span>
                                            </div>
                                            <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="usuario" id="usuario" class="form-control form-control-lg" placeholder="Usuario">
                                            </div>
                                            <div class="input-group form-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                </div>
                                                <input type="password" name="pass" id="pass" class="form-control form-control-lg" placeholder="Password">
                                            </div>
                                            <div class="pt-1 mb-4">
                                                <button class="btn btn-dark btn-lg btn-block" id="SignIn" name="SignIn" type="submit">Ingresar</button>
                                            </div>
                                        </form>
                                        <div id="idMensaje" style="display: none;" class="alert alert-danger my-3" role="alert">
                                            <p>El Usuario y/o Password no es correcto.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            const queryString = window.location.search;
            if (queryString != "") {
                const eCode = parseInt(queryString.replace("?c=", ""));
                if (eCode == 401) {
                    document.getElementById("idMensaje").style.display = "block";
                }
            }
        </script>
    </body>
</html>