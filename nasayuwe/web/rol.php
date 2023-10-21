<script>
    function cancelar(){
        location.href = 'roltb.php' //returns to parent
    }
</script>

<?php
    include_once "menu.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/conexiondb.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/rol.php";
    $oRoles = new Roles();
    $user_ro_id = "";
    $user_ro_description = "";

    if (isset($_POST['save'])) {
        $user_ro_id = $_POST['txtUser_ro_id'];
        $user_ro_description = $_POST['txtUser_ro_description'];
        if (isset($_SESSION['txtUsuario'])){
            $usuario = $_SESSION['txtUsuario'];
        }else{
            $usuario = null;
        }
        if ($oRoles->insertar($user_ro_id, $user_ro_description) == 200) {
            function_alert("Información Grabada...");
        }
    }
    if (isset($_POST['cancel'])) {
        //session_destroy();            //  destroys session 
        header('location: roltb.php');
    }
    if (isset($_GET["user_ro_id"])){
        $user_ro_id = $_GET["user_ro_id"];
        $listRecords = $oRoles->lista($user_ro_id);
        $user_ro_description = $listRecords->user_ro_description;
    }

    function function_alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Usuarios</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<!-- CSS Files -->
    <link href="/nasayuwe/lib_form/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/nasayuwe/lib_form/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="/nasayuwe/lib_form/css/demo.css" rel="stylesheet" />

    <style type="text/css">
        #popup {
            position: absolute;
            margin-right:auto;
            margin-left:auto;
            top: 0%;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #676767;
        }

        .contact-form {
            padding: 20px 20px 0px 0px;
        }
    </style>
</head>

<body>
    <div id="popup">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="card wizard-card" data-color="blue" id="wizardProfile">
                        <form class="contact-form" method="POST" name="frmUsuarios" action="">
                            <div class="logo-container">
                                <div class="col-sm-5 col-sm-offset-1">
                                    <img style="height:50px;" src="/nasayuwe/images/escudo.jpeg">
                                </div>
                            </div>
                            <div class="wizard-header" style="color:#3d6bbd;">
                                <h3>
                                    <b>ROLES</b><br>
                                </h3>
                            </div>
                            <div class="wizard-navigation">
                                <ul>
                                    <li><a href="#about" data-toggle="tab"></a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane" id="about">
                                    <div style="height:40px">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group">
                                                <label><strong>Descripci&oacute;n <small>(required)</small></strong></label>
                                                <input class="form-control" type="text" placeholder="Descripci&oacute;n" name="txtUser_ro_description" id="txtUser_ro_description" value="<?php echo (isset($user_ro_description))?$user_ro_description:'';?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height:40px">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-2">
                                            <div class="form-group">
                                                <button class="btn btn--radius btn--blue" name="save" type="submit" style="font-size:18px;font-weight:bold;">Grabar&nbsp;&nbsp;<i class="fa fa-save" style="font-size:28px;top:5px;position:relative;"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-sm-offset-0">
                                            <div class="form-group">
                                                <button class="btn btn--radius btn--blue" name="cancel" id="cancel" onclick="cancelar()" style="font-size:18px;font-weight:bold;">Salir&nbsp;&nbsp;<i class="fa fa-window-close" style="font-size:28px;top:5px;position:relative;"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="idMensaje" style="display: none;" class="alert alert-danger my-3" role="alert">
                                <p>Información Grabada.</p>
                            </div>
                            <input type="hidden" name="txtUser_ro_id" id="txtUser_ro_id" value="<?php echo (isset($user_ro_id))?$user_ro_id:'';?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
	<!--   Core JS Files   -->
	<script src="/nasayuwe/lib_form/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/gsdk-bootstrap-wizard.js"></script>
	<script src="/nasayuwe/lib_form/js/jquery.validate.min.js"></script>

</html>