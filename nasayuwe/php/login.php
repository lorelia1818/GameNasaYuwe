<?php
    session_start();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/usuario.php";
    $oUsuarios = new Usuarios();
    if (!empty($_POST)) {
        $response = null;
        // Añade aquí el código que desees en el caso de que la validación sea correcta
        $usuario = $_POST['usuario'];
        $pass = $_POST['pass'];
        $lPassC = sha1(md5("nasayuwe" . $pass));
        if ($oUsuarios->login($usuario, $lPassC) == 200) {
            $_SESSION['txtUsuario'] = $usuario;
            $_SESSION['txtEstado'] = null;
            header("Location: /GameNasaYuwe/nasayuwe/web/principal.php");
        } else {
            //echo $lPassC;
            header("Location: /GameNasaYuwe/nasayuwe/web/login.php?c=401");
        }
    }else{
        // Añade aquí el código que desees en el caso de que la validación no sea correcta o muestra
        header("Location: GameNasaYuwe/nasayuwe/web/login.php?c=402");
    }
?>