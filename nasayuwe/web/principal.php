<?php
    include_once "menu.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/conexiondb.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/usuario.php";
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Men&uacute; Principal</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<!-- CSS Files -->
    <link href="/GameNasaYuwe/nasayuwe/lib_form/css/bootstrap.min.css" rel="stylesheet" />
	<link href="/GameNasaYuwe/nasayuwe/lib_form/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="/GameNasaYuwe/nasayuwe/lib_form/css/demo.css" rel="stylesheet" />
</head>

<body>
    <?php 
    $oUsuario = new Usuarios();
    $user_id = "";
    $user_name = "";
    $user_age = "";
    $user_password = "";
    $user_role_user_ro_id = "";
    $user_ro_description = "";
    if (!empty($_SESSION['txtUsuario'])){
        $usuario = $_SESSION['txtUsuario'];
        $listRecords = $oUsuario->listaUsuario($usuario);
        $user_id = $listRecords->user_id;
        $user_name = $listRecords->user_name;
        $user_password = $listRecords->user_password;
        $user_age = $listRecords->user_age;
        $user_role_user_ro_id = $listRecords->user_role_user_ro_id;
        $user_ro_description = $listRecords->user_ro_description;
        if ($user_ro_description != "Administrador"){
    ?>
        <div class="image-container set-full-height" style="position:relative;top:-20px;background-image: url('assets/img/wizard.jpg');background:#3d6bbd;">
            <div style="height:40px">
            </div>
            <div class="container" style="background:#3d6bbd;">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="white" id="wizardProfile">
                                <form action="" method="">
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-checkbox">
                                                    <div class="icon" style="background:#fff">
                                                        <a href="jugar.php"><i class="fa fa-puzzle-piece" style="text-align:center;font-size:60px;color:#C00000;"></i></a>
                                                    </div>
                                                    <h6 style="color:#3d6bbd;">Jugar</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div> <!--  big container -->
        </div>
        <?php 
        } else {
        ?>
            <div class="image-container set-full-height" style="position:relative;top:-20px;background-image: url('assets/img/wizard.jpg');background:#3d6bbd;">
            <div style="height:40px">
            </div>
            <div class="container" style="background:#3d6bbd;">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="white" id="wizardProfile">
                                <form action="" method="">
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-checkbox">
                                                    <div class="icon" style="background:#fff">
                                                        <a href="usuariotb.php"><i class="fas fa-user-cog" style="font-size:60px;color:#C00000;"></i></a>
                                                    </div>
                                                    <h6 style="color:#3d6bbd;">Usuarios</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-checkbox">
                                                    <div class="icon" style="background:#fff">
                                                        <a href="wordstb.php"><i class="far fa-edit" style="font-size:60px;color:#C00000;"></i></a>
                                                    </div>
                                                    <h6 style="color:#3d6bbd;">Palabras</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-checkbox">
                                                    <div class="icon" style="background:#fff">
                                                        <a href="gamestb.php"><i class="fa fa-cogs" style="text-align:center;font-size:60px;color:#C00000;"></i></a>
                                                    </div>
                                                    <h6 style="color:#3d6bbd;">Games</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-checkbox">
                                                    <div class="icon" style="background:#fff">
                                                        <a href="jugar.php"><i class="fa fa-puzzle-piece" style="text-align:center;font-size:60px;color:#C00000;"></i></a>
                                                    </div>
                                                    <h6 style="color:#3d6bbd;">Jugar</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="col-sm-3">
                                                <div class="choice" data-toggle="wizard-checkbox">
                                                    <div class="icon" style="background:#fff">
                                                        <a href="estadisticastb.php"><i class="fa fa-chart-bar" style="font-size:60px;color:#C00000;"></i></a>
                                                    </div>
                                                    <h6 style="color:#3d6bbd;">Estad&iacute;sticas</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div> <!--  big container -->
        </div>
    <?php 
        }
    } else {
    ?>
        <div style='background-color:#3d6bbd;margin:0 auto; font-family: Tahoma; font-size:16pt;height:130px;width:800px' id="sesion" >
            <h3 align='center' style='color:PaleGoldenrod;text-shadow: 1px 1px 0 DarkGoldenrod;font-family:Tahoma; font-size:16pt'><span title='Iniciar Sesión'><a href="#login" onclick="window.parent.location='/nasayuwe/web/index.php'"><font style='color=#FFFFFF;font-family:Calibri;font-size:8pt;'><img align='center' src='/nasayuwe/images/Login.png' heigth='80px' width='80px'/></font></a></span><br>Sesi&oacute;n Finalizada...</h3>
        </div>
    <?php 
    } 
    ?>
</body>

	<!--   Core JS Files   -->
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/gsdk-bootstrap-wizard.js"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/jquery.validate.min.js"></script>

</html>
