<script>
    function cancelar(){
        location.href = 'wordstb.php' //returns to parent
    }

    function nuevo(){
        document.getElementById("txtGame_ty_id").value = "";
        document.getElementById("txtGame_ty_description").value = "";
        document.getElementById("txtGame_ty_level").value = "";
        document.getElementById("txtGame_ty_puntos").value = "";
        document.getElementById("txtGame_ty_records").value = "";
        document.getElementById("txtGame_ty_tiempo").value = "";
        document.getElementById("txtGame_ty_description").focus();
    }
</script>

<?php
    include_once "menu.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/conexiondb.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/games.php";
    $oGames = new Games();
    $game_ty_id = "";
    $game_ty_description = "";
    $game_ty_level = "";
    $game_ty_puntos = "";
    $game_ty_records = "";
    $game_ty_tiempo = "";

    if (isset($_POST['save'])) {
        $game_ty_id = $_POST['txtGame_ty_id'];
        $game_ty_description = $_POST['txtGame_ty_description'];
        $game_ty_level = $_POST['txtGame_ty_level'];
        $game_ty_puntos = $_POST['txtGame_ty_puntos'];
        $game_ty_records = $_POST['txtGame_ty_records'];
        $game_ty_tiempo = $_POST['txtGame_ty_tiempo'];
        if (isset($_SESSION['txtUsuario'])){
            $usuario = $_SESSION['txtUsuario'];
            }else{
            $usuario = null;
        }
        if ($oGames->insertar($game_ty_id, $game_ty_description, $game_ty_level, $game_ty_puntos, $game_ty_records, $game_ty_tiempo) == 200) {
            function_alert("Información Grabada...");
        }
    }
    if (isset($_POST['cancel'])) {
        //session_destroy();            //  destroys session 
        header('location: gamestb.php');
    }
    if (isset($_GET["game_ty_id"])){
        $game_ty_id = $_GET["game_ty_id"];
        $listRecords = $oGames->lista($game_ty_id);
        $game_ty_id = $listRecords->game_ty_id;
        $game_ty_description = $listRecords->game_ty_description;
        $game_ty_level = $listRecords->game_ty_level;
        $game_ty_puntos = $listRecords->game_ty_puntos;
        $game_ty_records = $listRecords->game_ty_records;
        $game_ty_tiempo = $listRecords->game_ty_tiempo;
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
        <title>Games</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="/GameNasaYuwe/nasayuwe/lib_form/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/GameNasaYuwe/nasayuwe/lib_form/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />
        <link href="/GameNasaYuwe/nasayuwe/lib_form/css/demo.css" rel="stylesheet" />
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
                            <form class="contact-form" method="POST" name="frmWords" action="" enctype="multipart/form-data" class="mb-3">
                                <div class="logo-container">
                                    <div class="col-sm-5 col-sm-offset-1">
                                        <img style="height:50px;" src="/GameNasaYuwe/nasayuwe/images/escudo.jpeg">
                                    </div>
                                </div>
                                <div class="wizard-header" style="color:#3d6bbd;">
                                    <h3>
                                        <b>GAMES</b><br>
                                    </h3>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a href="#about" data-toggle="tab"></a></li>
                                    </ul>
                                </div>
                                <div style="height:20px">
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label><strong>Descripci&oacute;n <small>(required)</small></strong></label>
                                                    <input class="form-control" type="text" placeholder="Descripci&oacute;n" name="txtGame_ty_description" id="txtGame_ty_description" value="<?php echo (isset($game_ty_description))?$game_ty_description:'';?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label><strong>Ver Reg. <small>(required)</small></strong></label>
                                                    <input class="form-control" style="text-align:right" type="number" placeholder="N&uacute;m. Reg." name="txtGame_ty_records" id="txtGame_ty_records" value="<?php echo (isset($game_ty_records))?$game_ty_records:'';?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label><strong>Puntos <small>(required)</small></strong></label>
                                                    <input class="form-control" style="text-align:right" type="number" placeholder="Puntos" name="txtGame_ty_puntos" id="txtGame_ty_puntos" value="<?php echo (isset($game_ty_puntos))?$game_ty_puntos:'';?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label><strong>Nivel <small>(required)</small></strong></label>
                                                    <input class="form-control" style="text-align:right" type="number" placeholder="Nivel" name="txtGame_ty_level" id="txtGame_ty_level" value="<?php echo (isset($game_ty_level))?$game_ty_level:'';?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label><strong>Tiempo <small>(segundos) </small><small> (required)</small></strong></label>
                                                    <input class="form-control" style="text-align:right" type="number" placeholder="Tiempo" name="txtGame_ty_tiempo" id="txtGame_ty_tiempo" value="<?php echo (isset($game_ty_tiempo))?$game_ty_tiempo:'';?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height:20px">
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-1">
                                                <div class="form-group">
                                                    <button class="btn btn--radius btn--blue" name="new" type="button" onclick="nuevo()" style="font-size:18px;font-weight:bold;">Nuevo&nbsp;&nbsp;<i class="fa fa-edit" style="font-size:28px;top:5px;position:relative;"></i></button>
                                                    <button class="btn btn--radius btn--blue" name="save" type="submit" style="font-size:18px;font-weight:bold;">Grabar&nbsp;&nbsp;<i class="fa fa-save" style="font-size:28px;top:5px;position:relative;"></i></button>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-sm-offset-2">
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
                                <input type="hidden" name="txtGame_ty_id" id="txtGame_ty_id" value="<?php echo (isset($game_ty_id))?$game_ty_id:'';?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/gsdk-bootstrap-wizard.js"></script>
	<script src="/GameNasaYuwe/nasayuwe/lib_form/js/jquery.validate.min.js"></script>
</html>
