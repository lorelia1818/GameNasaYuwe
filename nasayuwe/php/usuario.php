<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/sesion.php";
    class Usuarios extends Sesion
    {
        public function __construct()
        {
            parent::__construct();
            $this->sesion = null;
        }

        public function login($usuarios, $pass)
        {
            $query = "SELECT user_id, user_name, user_role_user_ro_id FROM usuario WHERE user_name = :usuario AND user_password = :pass";
            $oUsuario = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':usuario', $usuarios);
                $pQuery->bindParam(':pass', $pass);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($usuario = $pQuery->fetch()) {
                    $oUsuario = new Usuario();
                    $oUsuario->user_id = $usuario['user_id'];
                    $oUsuario->user_name = $usuario['user_name'];
                    $oUsuario->user_role_user_ro_id = $usuario['user_role_user_ro_id'];
                }
                if ($oUsuario != null) {
                    return 200;
                } else {
                    return 401;
                }
            }
        }

        public function listar()
        {
            $query = "SELECT user_id, user_name, user_role_user_ro_id FROM usuario";
            $oUsuario = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($usuario = $pQuery->fetch()) {
                    $oUsuario = new Usuario();
                    $oUsuario->user_id = $usuario['user_id'];
                    $oUsuario->user_name = $usuario['user_name'];
                    $oUsuario->user_role_user_ro_id = $usuario['user_role_user_ro_id'];
                }
                if ($oUsuario != null) {
                    return $oUsuario;
                } else {
                    return null;
                }
            }
        }

        public function lista($user_id)
        {
            $query = "SELECT user_id, user_name, user_age, user_role_user_ro_id FROM usuario WHERE user_id = :user_id";
            $oUsuario = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':user_id', $user_id);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($usuario = $pQuery->fetch()) {
                    $oUsuario = new Usuario();
                    $oUsuario->user_id = $usuario['user_id'];
                    $oUsuario->user_name = $usuario['user_name'];
                    $oUsuario->user_age = $usuario['user_age'];
                    $oUsuario->user_role_user_ro_id = $usuario['user_role_user_ro_id'];
                }
                if ($oUsuario != null) {
                    return $oUsuario;
                } else {
                    return null;
                }
            }
        }

        public function listaUsuario($usuario)
        {
            $query = "SELECT u.user_id, u.user_name, u.user_password, u.user_age, u.user_role_user_ro_id, r.user_ro_description FROM usuario u, user_role r WHERE r.user_ro_id = u.user_role_user_ro_id AND u.user_name = :usuario";
            $oUsuario = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':usuario', $usuario);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($usuario = $pQuery->fetch()) {
                    $oUsuario = new Usuario();
                    $oUsuario->user_id = $usuario['user_id'];
                    $oUsuario->user_name = $usuario['user_name'];
                    $oUsuario->user_age = $usuario['user_age'];
                    $oUsuario->user_role_user_ro_id = $usuario['user_role_user_ro_id'];
                    $oUsuario->user_ro_description = $usuario['user_ro_description'];
                }
                if ($oUsuario != null) {
                    return $oUsuario;
                } else {
                    return null;
                }
            }
        }

        public function insertar($user_id, $user_name, $user_password, $user_age, $user_role_user_ro_id){
            $conexion = conexionDB::conectar();
            $strQuery = "SELECT COUNT(*) AS allcount FROM usuario WHERE user_name = :user_name";
            $stmt = $conexion->prepare($strQuery);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];
            if ($totalRecordwithFilter == 0){
                $query = "INSERT INTO usuario (user_name, user_password, user_age, user_role_user_ro_id) VALUES (:user_name, :user_password, :user_age, :user_role_user_ro_id)";
                $oUsuario = null;
                if ($conexion) {
                    $lPassC = sha1(md5("nasayuwe" . $user_password));
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':user_name', $user_name);
                    $pQuery->bindParam(':user_password', $lPassC);
                    $pQuery->bindParam(':user_age', $user_age);
                    $pQuery->bindParam(':user_role_user_ro_id', $user_role_user_ro_id);
                    $pQuery->execute();
                }
            }else{
                $query = "UPDATE usuario SET user_password = :user_password, user_age = :user_age, user_role_user_ro_id = :user_role_user_ro_id WHERE user_name = :user_name";
                if ($conexion) {
                    $lPassC = sha1(md5("nasayuwe" . $user_password));
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':user_password', $lPassC);
                    $pQuery->bindParam(':user_age', $user_age);
                    $pQuery->bindParam(':user_role_user_ro_id', $user_role_user_ro_id);
                    $pQuery->bindParam(':user_name', $user_name);
                    $pQuery->execute();
                }
            }
            if ($pQuery) {
                return 200;
            } else {
                return 401;
            }
        }
    }

    class Usuario
    {
        public $user_role_user_ro_id = 0;
        public $user_ro_description = "";
        public $user_id = 0;
        public $user_name = "";
        public $user_password= "";
        public $user_age = "";
    }