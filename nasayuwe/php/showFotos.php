<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
            }

            /* Modal Content (image) */
            .modal-content {
                width: 100%;
                height: 100%;
                position: absolute;
                margin: auto;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                /*object-fit: scale-down;*/
                object-fit: contain;
                max-width: 30%;
                max-height: 30%;
            }

            /* Caption of Modal Image */
            #caption {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 100%;
                text-align: center;
                color: #ccc;
                padding: 10px 0;
                height: 150px;
            }

            /* Add Animation */
            .modal-content, #caption {  
                -webkit-animation-name: zoom;
                -webkit-animation-duration: 0.6s;
                animation-name: zoom;
                animation-duration: 0.6s;
            }

            @-webkit-keyframes zoom {
                from {-webkit-transform:scale(0)} 
                to {-webkit-transform:scale(1)}
            }

            @keyframes zoom {
                from {transform:scale(0)} 
                to {transform:scale(1)}
            }

            /* The Close Button */
            .close {
                float: right;
                margin-top: 35px;
                margin-right: 35px;
                background: url(/nasayuwe/lib_form/images/close.png) top right no-repeat;
                display: block;
                width: 30px;
                height: 30px;
                transition: 0.3s;
                text-align: right;
                outline:0;
                filter: alpha(Opacity=70);
                opacity: .7;
                -webkit-transition: opacity .2s;
                -moz-transition: opacity .2s;
                -o-transition: opacity .2s;
                transition: opacity .2s
            }

            .close:hover,
            .close:focus {
                cursor: pointer;
                filter: alpha(Opacity=100);
                opacity: 1;
            }

            /* 100% Image Width on Smaller Screens */
            @media only screen and (max-width: 700px){
                .modal-content {
                    width: 100%;
                }
            }
        </style>
        <link href="/nasayuwe/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <?php
            include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/sesion.php";
            include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/web/jugar.php";
            $oConexion = new conexiondb();
            if(isset($_GET['word_id'])){
                $word_id = $_GET['word_id'];
                $query = "SELECT w.word_id, w.word_description, w.word_spanish_meaning, w.word_sound, w.word_play, w.word_graph, w.nomFoto, w.foto FROM words w WHERE w.word_id = :word_id";
                $conexion = $oConexion->conectar();
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':word_id', $word_id);
                    $pQuery->execute();
                    $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                    while ($word = $pQuery->fetch()) {
                        $nomFoto = $word['nomFoto'];
                        $foto = $word['foto'];
                    }
                    $file_extension = strtolower(substr(strrchr($nomFoto,"."),1));?>
                    <!--<div id="popup">-->
                    <div id="myModal" class="modal">
                    <?php 
                        switch ($file_extension) {
                            case "gif": ?><img id="myImg" style="visibility:hidden" src="data:image/gif;charset=utf8;base64,<?php echo base64_encode($foto); ?>" /><?php break;
                            case "png": ?><img id="myImg" style="visibility:hidden" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($foto); ?>" /><?php break;
                            case "jpe": case "jpeg":
                            case "jpg": ?><img id="myImg" style="visibility:hidden" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($foto); ?>" /><?php break;
                        }?>
                        <span class="close"></span>
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                    </div>
                    <script>
                        // Get the modal
                        var modal = document.getElementById("myModal");

                        // Get the image and insert it inside the modal - use its "alt" text as a caption
                        var img = document.getElementById("myImg");
                        var modalImg = document.getElementById("img01");
                        var captionText = document.getElementById("caption");
                        //img.onclick = function(){
                        modal.style.display = "block";
                        modalImg.src = img.src;
                        captionText.innerHTML = img.alt;
                        //}

                        // Get the <span> element that closes the modal
                        var span = document.getElementsByClassName("close")[0];

                        // When the user clicks on <span> (x), close the modal
                        span.onclick = function() { 
                            modal.style.display = "none";
                            let url="/nasayuwe/web/wordstb.php";
                            location.href = url;
                        }
                    </script>
                    <?php
                }
            }
        ?>
    </body>
</html>