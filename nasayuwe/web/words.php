<script>
    function cancelar(){
        location.href = 'wordstb.php' //returns to parent
    }

    function nuevo(){
        document.getElementById("txtWord_id").value = "";
        document.getElementById("txtWord_description").value = "";
        document.getElementById("txtWord_spanish_meaning").value = "";
        document.getElementById("txtWord_sound").value = "";
        document.getElementById("txtWord_play").value = "";
        document.getElementById("txtWord_graph").value = "";
        document.getElementById("txtWord_description").focus();
    }
</script>

<?php
    include_once "menu.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/conexiondb.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/words.php";
    $oWords = new Words();
    $word_id = "";
    $word_description = "";
    $word_spanish_meaning = "";
    $word_sound = "";
    $word_play = "";
    $word_graph = "";

    if (isset($_POST['save'])) {
        if(!empty(basename($_FILES['txtFoto']['name']))){
            $fileName = basename($_FILES['txtFoto']['name']); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            $file = $_FILES['txtFoto']['tmp_name']; 
            if ($fileName != ""){
                $fileContent = file_get_contents($file);
            }
            $word_id = $_POST['txtWord_id'];
            $word_description = $_POST['txtWord_description'];
            $word_spanish_meaning = $_POST['txtWord_spanish_meaning'];
            $word_sound = $_POST['txtWord_sound'];
            $word_play = $_POST['txtWord_play'];
            $word_graph = $_POST['txtWord_graph'];
            if (isset($_SESSION['txtUsuario'])){
                $usuario = $_SESSION['txtUsuario'];
            }else{
                $usuario = null;
            }
            if ($oWords->inserta($word_id, $word_description, $word_spanish_meaning, $word_sound, $word_play, $word_graph, $fileName, $fileContent) == 200) {
                function_alert("Información Grabada...");
            }
        }else{
            $word_id = $_POST['txtWord_id'];
            $word_description = $_POST['txtWord_description'];
            $word_spanish_meaning = $_POST['txtWord_spanish_meaning'];
            $word_sound = $_POST['txtWord_sound'];
            $word_play = $_POST['txtWord_play'];
            $word_graph = $_POST['txtWord_graph'];
            if (isset($_SESSION['txtUsuario'])){
                $usuario = $_SESSION['txtUsuario'];
            }else{
                $usuario = null;
            }
            if ($oWords->insertar($word_id, $word_description, $word_spanish_meaning, $word_sound, $word_play, $word_graph) == 200) {
                function_alert("Información Grabada...");
            }
        }
    }
    if (isset($_POST['cancel'])) {
        //session_destroy();            //  destroys session 
        header('location: wordstb.php');
    }
    if (isset($_GET["word_id"])){
        $word_id = $_GET["word_id"];
        $listRecords = $oWords->lista($word_id);
        $word_id = $listRecords->word_id;
        $word_description = $listRecords->word_description;
        $word_spanish_meaning = $listRecords->word_spanish_meaning;
        $word_sound = $listRecords->word_sound;
        $word_play = $listRecords->word_play;
        $word_graph = $listRecords->word_graph;
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
        <title>Words</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="/nasayuwe/lib_form/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/nasayuwe/lib_form/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />
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
                            <form class="contact-form" method="POST" name="frmWords" action="" enctype="multipart/form-data" class="mb-3">
                                <div class="logo-container">
                                    <div class="col-sm-5 col-sm-offset-1">
                                        <img style="height:50px;" src="/nasayuwe/images/escudo.jpeg">
                                    </div>
                                </div>
                                <div class="wizard-header" style="color:#3d6bbd;">
                                    <h3>
                                        <b>WORDS</b><br>
                                    </h3>
                                </div>
                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a href="#about" data-toggle="tab"></a></li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label><strong>Descripci&oacute;n <small>(required)</small></strong></label>
                                                    <input class="form-control" type="text" placeholder="Descripci&oacute;n" name="txtWord_description" id="txtWord_description" value="<?php echo (isset($word_description))?$word_description:'';?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label><strong>Significado <small>(required)</small></strong></label>
                                                    <input class="form-control" type="text" placeholder="Significado" name="txtWord_spanish_meaning" id="txtWord_spanish_meaning" value="<?php echo (isset($word_spanish_meaning))?$word_spanish_meaning:'';?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5 col-sm-offset-1">
                                                <h4 style="font-size:14px;font-weight:bold;">Seleccionar Foto</h4>
                                                <div class="custom-file mb-3">
                                                    <input type="file" class="custom-file-input" name="txtFoto" id="txtFoto" accept="image/gif, image/jpeg, image/png, image/bmp, image/jpg">
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
                                <input type="hidden" name="txtWord_id" id="txtWord_id" value="<?php echo (isset($word_id))?$word_id:'';?>">
                                <input type="hidden" name="txtWord_sound" id="txtWord_sound" value="<?php echo (isset($word_sound))?$word_sound:'';?>">
                                <input type="hidden" name="txtWord_play" id="txtWord_play" value="<?php echo (isset($word_play))?$word_play:'';?>">
                                <input type="hidden" name="txtWord_graph" id="txtWord_graph" value="<?php echo (isset($word_graph))?$word_graph:'';?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
	<script>
	    $(".custom-file-input").on("change", function() {
  		    var fileName = $(this).val().split("\\").pop();
  		    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	    });
    </script>
	<script src="/nasayuwe/lib_form/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/gsdk-bootstrap-wizard.js"></script>
	<script src="/nasayuwe/lib_form/js/jquery.validate.min.js"></script>

</html>
