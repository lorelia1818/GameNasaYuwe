<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/sesion.php";

    class Roles extends Sesion
    {
        public function __construct()
        {
            parent::__construct();
            $this->sesion = null;
        }

        public function listado()
        {
            $query = "SELECT user_ro_id, user_ro_description FROM user_role ORDER BY 2";
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                return $pQuery;
            }
        }

        public function lista($user_ro_id)
        {
            $query = "SELECT user_ro_id, user_ro_description FROM user_role WHERE user_ro_id = :user_ro_id";
            $oRoles = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':user_ro_id', $user_ro_id);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($rol = $pQuery->fetch()) {
                    $oRoles = new Roles();
                    $oRoles->user_ro_id = $rol['user_ro_id'];
                    $oRoles->user_ro_description = $rol['user_ro_description'];
                }
                if ($oRoles != null) {
                    return $oRoles;
                } else {
                    return null;
                }
            }
        }

        public function insertar($user_ro_id, $user_ro_description){
            if ($user_ro_id == null || $user_ro_id == 0){
                $query = "INSERT INTO user_role (user_ro_description) VALUES (:user_ro_description)";
                $oRoles = null;
                $conexion = conexionDB::conectar();
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':user_ro_description', $user_ro_description);
                    $pQuery->execute();
                }
            }else{
                $query = "UPDATE user_role SET user_ro_description = :user_ro_description WHERE user_ro_id = :user_ro_id";
                $oListado = null;
                $conexion = conexionDB::conectar();
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':user_ro_description', $user_ro_description);
                    $pQuery->bindParam(':user_ro_id', $user_ro_id);
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

    class Rol
    {
        public $user_ro_id = 0;
        public $user_ro_description = "";
    }
