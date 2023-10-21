<script type="text/javascript">
    var inicio=0;
    var timeout=0;
        
    function empezarDetener(){
        if(timeout==0){
            // empezar el cronometro
            // Obtenemos el valor actual
            inicio=new Date().getTime();
            // Guardamos el valor inicial en la base de datos del navegador
            localStorage.setItem("inicio",inicio);
            // iniciamos el proceso
            funcionando();
        }else{
            // detemer el cronometro
            clearTimeout(timeout);
            // Eliminamos el valor inicial guardado
            localStorage.removeItem("inicio");
            timeout=0;   
        }
        if (document.getElementById('txtEstadoFinal').value != ""){
            clearTimeout(timeout);        
            localStorage.removeItem("inicio");
            timeout=0;
            document.getElementById('crono').innerHTML = document.getElementById('txtEstadoFinal').value;
        }
    }
        
    function funcionando()
    {
        // obteneos la fecha actual
        var actual = new Date().getTime();
        // obtenemos la diferencia entre la fecha actual y la de inicio
        var diff=new Date(actual-inicio);
        // mostramos la diferencia entre la fecha actual y la inicial
        var result=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
        document.getElementById('crono').innerHTML = result;
        var tiempo = secondsToString(document.getElementById('txtGame_ty_tiempo').value);
        // Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
        timeout=setTimeout("funcionando()",1000);
        if (result == tiempo){
            clearTimeout(timeout);        
            localStorage.removeItem("inicio");
            timeout=0;
            document.getElementById('crono').innerHTML = "G A M E   O V E R . . .";
        }
    }
        
    /* Funcion que pone un 0 delante de un valor si es necesario */
    function LeadingZero(Time)
    {
        return (Time < 10) ? "0" + Time : + Time;
    }
        
    window.onload=function()
    {
        if(localStorage.getItem("inicio")!=null)
        {
            // Si al iniciar el navegador, la variable inicio que se guarda
            // en la base de datos del navegador tiene valor, cargamos el valor
            // y iniciamos el proceso.
            inicio=localStorage.getItem("inicio");
            document.getElementById("boton").value="Detener";
            funcionando();
        }
    }

    function secondsToString(seconds) {
        var hour = Math.floor(seconds / 3600);
        hour = (hour < 10)? '0' + hour : hour;
        var minute = Math.floor((seconds / 60) % 60);
        minute = (minute < 10)? '0' + minute : minute;
        var second = seconds % 60;
        second = (second < 10)? '0' + second : second;
        return hour + ':' + minute + ':' + second;
    }
</script>
<?php
    include_once "menu.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/conexiondb.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/words.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/games.php";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/usuario.php";
    $oWords = new Words();
    $oWord = new Words();
    $oGames = new Games();
    $oUsuarios = new Usuarios();
    $wordGame_id = "";
    $wordGame_description = "";
    $word_id_1 = "";
    $word_description_1 = "";
    $word_spanish_meaning_1 = "";
    $word_sound_1 = "";
    $word_play_1 = "";
    $word_graph_1 = "";
    $nomFoto_1 = "";
    $user_user_id = "";
    $game_time = "";
    $estado = "";
    $estadoFinal = "";
    $max_game_ty_level = 0;

    $word_id_2 = "";
    $word_description_2 = "";
    $word_spanish_meaning_2 = "";
    $word_sound_2 = "";
    $word_play_2 = "";
    $word_graph_2 = "";
    $nomFoto_2 = "";
    $usuario = $_SESSION['txtUsuario'];
    if ($_SESSION['txtEstado'] == 'P'){
        $listRecords = $oGames->nivelMinimo($usuario);
    }else if ($_SESSION['txtEstado'] == 'N'){
        $listRecords = $oGames->nivelMinimo($usuario);
    }else if ($_SESSION['txtEstado'] == null){
        $listRecords = $oGames->nivelMinimo($usuario);
    }else{
        $listRecords = $oGames->nivel($usuario, $_SESSION['txtEstado']);
    }
    $game_ty_id = $listRecords->game_ty_id;
    $game_ty_description = $listRecords->game_ty_description;
    $game_ty_level = $listRecords->game_ty_level;
    $game_ty_puntos = $listRecords->game_ty_puntos;
    $game_ty_records = $listRecords->game_ty_records;
    $game_ty_tiempo = $listRecords->game_ty_tiempo;

    if (isset($_GET['p_id1']) && isset($_GET['p_id2']) && $_GET['p_cont'] == 2){
        $p_id1 = $_GET['p_id1'];
        $p_id2 = $_GET['p_id2'];
        $p_contar = $_GET['p_cont'];
        $listRecords = $oWords->lista(SUBSTR($p_id1, 0, STRLEN($p_id1) - 1));
        $word_id_1 = $listRecords->word_id;
        $word_description_1 = $listRecords->word_description;
        $word_spanish_meaning_1 = $listRecords->word_spanish_meaning;
        $word_sound_1 = $listRecords->word_sound;
        $word_play_1 = $listRecords->word_play;
        $word_graph_1 = $listRecords->word_graph;
        $nomFoto_1 = $listRecords->nomFoto;

        $listRecords = $oWords->lista(SUBSTR($p_id2, 0, STRLEN($p_id2) - 1));
        $word_id_2 = $listRecords->word_id;
        $word_description_2 = $listRecords->word_description;
        $word_spanish_meaning_2 = $listRecords->word_spanish_meaning;
        $word_sound_2 = $listRecords->word_sound;
        $word_play_2 = $listRecords->word_play;
        $word_graph_2 = $listRecords->word_graph;
        $nomFoto_2 = $listRecords->nomFoto;
        if ($word_id_1 == $word_id_2){
            $listRecordUsu = $oUsuarios->listaUsuario($usuario);
            $user_user_id = $listRecordUsu->user_id;
            $game_time = new DateTime();
            $listRecord = $oGames->nivelMaximo();
            $max_game_ty_level = $listRecord->game_ty_level;
            if ($max_game_ty_level > $game_ty_level + 1){
                if ($_SESSION['txtEstado'] == 'N'){
                    $listaRecord = $oGames->inserta($game_time->format("Y-m-d H:i:s"), $game_ty_id, $user_user_id, 'N');
                    $estado = $listRecord->game_id;
                    $_SESSION['txtEstado'] = $estado;
                }else{
                    $oGames->insertaNivel($game_time->format("Y-m-d H:i:s"), $game_ty_id, $user_user_id, $estado);
                }
                $url="/nasayuwe/web/jugar.php";
                echo ("<script>location.href='$url'</script>");
                $listRecords = $oGames->nivel($usuario, $estado);
                $game_ty_id = $listRecords->game_ty_id;
                $game_ty_description = $listRecords->game_ty_description;
                $game_ty_level = $listRecords->game_ty_level;
                $game_ty_puntos = $listRecords->game_ty_puntos;
                $game_ty_records = $listRecords->game_ty_records;
                $game_ty_tiempo = $listRecords->game_ty_tiempo;
            }else if ($max_game_ty_level == $game_ty_level + 1){
                if ($nomFoto_1 != null){
                    $url= "/nasayuwe/php/showFoto.php?word_id=".$word_id_1;
                    echo ("<script>location.href='$url'</script>");
                }
                $oGames->inserta($game_time->format("Y-m-d H:i:s"), $game_ty_id, $user_user_id, $estado);
                $estado = $listRecord->game_id;
                $_SESSION['txtEstado'] = $estado;
                $listRecords = $oGames->nivel($usuario, $estado);
                $game_ty_id = $listRecords->game_ty_id;
                $game_ty_description = $listRecords->game_ty_description;
                $game_ty_level = $listRecords->game_ty_level;
                $game_ty_puntos = $listRecords->game_ty_puntos;
                $game_ty_records = $listRecords->game_ty_records;
                $game_ty_tiempo = $listRecords->game_ty_tiempo;
                $url="/nasayuwe/web/jugar.php";
                echo ("<script>location.href='$url'</script>");
            }else{
                $estado = $_SESSION['txtEstado'];
                $game_time = new DateTime();
                $oGames->insertaNivel($game_time->format("Y-m-d H:i:s"), $game_ty_id, $user_user_id, $estado);
                $_SESSION['txtEstado'] = 'N';
                if ($nomFoto_1 != null){
                    $url= "/nasayuwe/php/showFoto.php?word_id=".$word_id_1;
                    echo ("<script>location.href='$url'</script>");
                }
                function_alert("G A M E   F I N I S H E D . . .");
                $url="/nasayuwe/web/jugar.php";
                echo ("<script>location.href='$url'</script>");
            }
        }else{
            $estado = $_SESSION['txtEstado'];
            $listRecordUsu = $oUsuarios->listaUsuario($usuario);
            $user_user_id = $listRecordUsu->user_id;
            $game_time = new DateTime();
            $_SESSION['txtEstado'] = 'N';
            $listRecord = $oGames->nivelMaximo();
            $max_game_ty_level = $listRecord->game_ty_level;
            if ($max_game_ty_level < $game_ty_level + 1){
                $oGames->insertaNivel($game_time->format("Y-m-d H:i:s"), $game_ty_id, $user_user_id, $estado);
                function_alert("G A M E    O V E R . . .");
                $url="/nasayuwe/web/jugar.php";
                echo ("<script>location.href='$url'</script>");
                $_SESSION['txtEstado'] = null;
            }
        }
        if ($word_id_1 != $word_id_2){
            $_SESSION['txtEstado'] = 'N';
            function_alert("G A M E    O V E R . . .");
            $url="/nasayuwe/web/jugar.php";
            echo ("<script>location.href='$url'</script>");
            
        }
    }

    function function_alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <title>My Drag-and-Drop juego</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link href="/nasayuwe/lib_form/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/nasayuwe/lib_form/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />
        <link href="/nasayuwe/lib_form/css/demo.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/timecircles/1.5.3/TimeCircles.min.js" integrity="sha512-FofOhk0jW4BYQ6CFM9iJutqL2qLk6hjZ9YrS2/OnkqkD5V4HFnhTNIFSAhzP3x//AD5OzVMO8dayImv06fq0jA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            .juego-parent {
                border: 2px solid #DFA612;
                color: black;
                display: flex;
                font-family: sans-serif;
                font-weight: bold;
            }

            .juego-origin {
                flex-basis: 100%;
                flex-grow: 1;
                padding: 10px;
                display:grid;
                grid-template-columns:repeat(3, 1fr);
                gap: 10px;
            }

            .juego-draggable {
                background-color: #4AAE9B;
                font-weight: normal;
                margin-bottom: 10px;
                margin-top: 10px;
                padding: 10px;
            }

            .juego-dropzone {
                background-color: #6DB65B;
                flex-basis: 100%;
                flex-grow: 1;
                padding: 10px;
            }

            .crono_wrapper {
                width:400px;
            }
        </style>
    </head>
    <body onload="empezarDetener()">
        <script type="text/javascript">
            let v_contar = 0;
            function onDragStart(event) {
                if (document.getElementById('crono').innerHTML != "G A M E   O V E R . . ." && document.getElementById('crono').innerHTML != "T E R M I N A D O . . ."){
                    event
                        .dataTransfer
                        .setData('text/plain', event.target.id);
                    event
                        .currentTarget
                        .style
                        .backgroundColor = 'yellow';
                }
            }

            function onDragOver(event) {
                event.preventDefault();
            }

            $(document).ready(function(){
                $("#juego-origin").click(function(){
                    $.ajax({
                        'type': 'get',
                        'cache': false,
                        'url': 'jugar.php?p_id='+v_numId+'&p_contar'+v_contar,
                        success: function(data){
                            $("#response").html(data)
                        },
                        error: function(data){
                            $("#response").html(data)
                        }
                    })
                })
            })

            function onDrop(event) {
                if (document.getElementById('crono').innerHTML != "G A M E   O V E R . . ." && document.getElementById('crono').innerHTML != "T E R M I N A D O . . ."){
                    v_contar = v_contar + 1;
                    document.getElementById("txtContar").value = v_contar;
                    if (v_contar <= 2){
                        const id = event
                            .dataTransfer
                            .getData('text');
                        const draggableElement = document.getElementById(id);
                        if (v_contar == 1){
                            document.getElementById("txtIdA").value = id;
                        }
                        if (v_contar == 2){
                            document.getElementById("txtIdB").value = id;
                            window.location.href = window.location.href + "?p_id1="+document.getElementById("txtIdA").value + "&p_id2="+document.getElementById("txtIdB").value + "&p_cont="+document.getElementById("txtContar").value;
                        }
                        const dropzone = event.target;
                        dropzone.appendChild(draggableElement);
                        event
                            .dataTransfer
                            .clearData();
                    }
                }
            }
        </script>
        <form id="frmJuego" method="GET" >
            <div class="container">
                <div class="row">
                    <div style='margin-left:-100px;' class="col-sm-1">
                        <div class="form-group">
                            <div class="icon" style="background:#fff">
                                <a href="principal.php"><i class="fa fa-home fa-x5" style="font-size:60px;color:#C00000;"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-sm-offset-1">
                        <div class="form-group">
                            <label><strong>NIVEL</strong></label>
                            <input class="form-control" style="border:0px;font-size:24pt;font-weight:bold" type="text" name="txtNivel" id="txtNivel" value="<?php echo (isset($game_ty_level))?$game_ty_level:'';?>">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label><strong>TIEMPO</strong></label>
                            <input class="form-control" style="margin-left:-20px;border:0px;font-size:20pt;font-weight:bold" type="text" name="textGame_ty_tiempo" id="textGame_ty_tiempo" value="<?php echo (isset($game_ty_tiempo))?$game_ty_tiempo:'';?> Seg.">
                            <input class="form-control" type="hidden" name="txtGame_ty_tiempo" id="txtGame_ty_tiempo" value="<?php echo (isset($game_ty_tiempo))?$game_ty_tiempo:'';?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="crono_wrapper" >
                                <h2 id='crono'>00:00:00</h2>
                            </div>
                        </div>
                    </div>
                    <input class="form-control" type="hidden" name="txtGame_ty_records" id="txtGame_ty_records" value="<?php echo (isset($game_ty_records))?$game_ty_records:'';?>">
                    <input class="form-control" type="hidden" name="txtGame_ty_puntos" id="txtGame_ty_puntos" value="<?php echo (isset($game_ty_puntos))?$game_ty_puntos:'';?>">
                    <input class="form-control" type="hidden" name="txtEstadoFinal" id="txtEstadoFinal" value="<?php echo (isset($estadoFinal))?$estadoFinal:'';?>">
                </div>
            </div>
            <div class="juego-parent">
                <div class="juego-origin">
                    <?php
                        $pQuery = $oWord->listar($game_ty_records, $_SESSION['txtUsuario']);
                        $pQuery->execute();
                        $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                        while ($word = $pQuery->fetch()) {
                            $pQuerys = $oWords->listas($word["word_id"]);
                            $pQuerys->execute();
                            $pQuerys->setFetchMode(PDO::FETCH_ASSOC);
                            while ($words = $pQuerys->fetch()) {
                                $wordGame_id = strval($words["word_id"]).'A';
                                $wordGame_description = $words["word_description"];
                                $oWord->insertGame($wordGame_id, $wordGame_description, $_SESSION['txtUsuario']);
                            }
                            $pQuerys = $oWords->listas($word["word_id"]);
                            $pQuerys->execute();
                            $pQuerys->setFetchMode(PDO::FETCH_ASSOC);
                            while ($words = $pQuerys->fetch()) {
                                $wordGame_id = strval($words["word_id"]).'B';
                                $wordGame_description = $words["word_spanish_meaning"];
                                $oWord->insertGame($wordGame_id, $wordGame_description, $_SESSION['txtUsuario']);
                            }
                        } 
                        $pQuerys = $oWords->listGame($_SESSION['txtUsuario']);
                        $pQuerys->execute();
                        $pQuerys->setFetchMode(PDO::FETCH_ASSOC);
                        while ($words = $pQuerys->fetch()) {?>
                            <div style='width:screen.width/2;' id="<?php echo $words["word_id"];?>" class="juego-draggable" draggable="true" ondragstart="onDragStart(event);">
                                <?php echo $words["word_description"];?>
                            </div>
                        <?php }?>
                </div>
                <div class="juego-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);">
                    Coloca las Palabras...
                </div>
            </div>
            <input type="hidden" id="txtContar" name="txtContar">
            <input type="hidden" id="txtIdA" name="txtIdA">
            <input type="hidden" id="txtIdB" name="txtIdB">
        </form>
    </body>
	<script src="/nasayuwe/lib_form/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
	<script src="/nasayuwe/lib_form/js/gsdk-bootstrap-wizard.js"></script>
	<script src="/nasayuwe/lib_form/js/jquery.validate.min.js"></script>
</html>