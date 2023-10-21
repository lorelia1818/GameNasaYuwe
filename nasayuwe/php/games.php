<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/sesion.php";
    class Games extends Sesion
    {
        public function __construct()
        {
            parent::__construct();
            $this->sesion = null;
        }

        public function listado()
        {
            $query = "SELECT g.game_ty_id, g.game_ty_description, g.game_ty_level, g.game_ty_puntos, g.game_ty_records, g.game_ty_tiempo FROM game_type g ORDER BY 5";
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                return $pQuery;
            }
        }

        public function lista($game_ty_id){
            $query = "SELECT g.game_ty_id, g.game_ty_description, g.game_ty_level, g.game_ty_puntos, g.game_ty_records, g.game_ty_tiempo FROM game_type g WHERE game_ty_id = :game_ty_id";
            $oGames = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':game_ty_id', $game_ty_id);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($game = $pQuery->fetch()) {
                    $oGames = new Games();
                    $oGames->game_ty_id = $game['game_ty_id'];
                    $oGames->game_ty_description = $game['game_ty_description'];
                    $oGames->game_ty_level = $game['game_ty_level'];
                    $oGames->game_ty_puntos = $game['game_ty_puntos'];
                    $oGames->game_ty_records = $game['game_ty_records'];
                    $oGames->game_ty_tiempo = $game['game_ty_tiempo'];
                }
                if ($oGames != null) {
                    return $oGames;
                } else {
                    return null;
                }
            }
        }

        public function insertar($game_ty_id, $game_ty_description, $game_ty_level, $game_ty_puntos, $game_ty_records, $game_ty_tiempo){
            $conexion = conexionDB::conectar();
            $strQuery = "SELECT COUNT(*) AS allcount FROM game_type WHERE game_ty_description = :game_ty_description";
            $stmt = $conexion->prepare($strQuery);
            $stmt->bindParam(':game_ty_description', $game_ty_description);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];
            if ($totalRecordwithFilter == 0){
                $query = "INSERT INTO game_type (game_ty_description, game_ty_level, game_ty_puntos, game_ty_records, game_ty_tiempo) VALUES (:game_ty_description, :game_ty_level, :game_ty_puntos, :game_ty_records, :game_ty_tiempo)";
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':game_ty_description', $game_ty_description);
                    $pQuery->bindParam(':game_ty_level', $game_ty_level);
                    $pQuery->bindParam(':game_ty_puntos', $game_ty_puntos);
                    $pQuery->bindParam(':game_ty_records', $game_ty_records);
                    $pQuery->bindParam(':game_ty_tiempo', $game_ty_tiempo);
                    $pQuery->execute();
                }
            }else{
                $query = "UPDATE game_type SET game_ty_description = :game_ty_description, game_ty_level = :game_ty_level, game_ty_puntos = :game_ty_puntos, game_ty_records = :game_ty_records, game_ty_tiempo = :game_ty_tiempo WHERE game_ty_id = :game_ty_id";
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':game_ty_description', $game_ty_description);
                    $pQuery->bindParam(':game_ty_level', $game_ty_level);
                    $pQuery->bindParam(':game_ty_puntos', $game_ty_puntos);
                    $pQuery->bindParam(':game_ty_records', $game_ty_records);
                    $pQuery->bindParam(':game_ty_tiempo', $game_ty_tiempo);
                    $pQuery->bindParam(':game_ty_id', $game_ty_id);
                    $pQuery->execute();
                }
            }
            if ($pQuery) {
                return 200;
            } else {
                return 401;
            }
        }

        public function nivel($usuario, $estado){
            $oGames = new Games();
            $conexion = conexionDB::conectar();
            $query = "SELECT game_ty_id, game_ty_description, game_ty_level, game_ty_puntos, game_ty_records, game_ty_tiempo FROM game_type gt WHERE gt.game_ty_level IN (SELECT MIN(t.game_ty_level) AS minimo FROM game_type t WHERE t.game_ty_id NOT IN (SELECT g.game_ty_id FROM game g WHERE g.estado = :estado AND g.user_user_id IN (SELECT u.user_id FROM usuario u WHERE u.user_name = :usuario)))";
            $pQuery = $conexion->prepare($query);
            $pQuery->bindParam(':estado', $estado);
            $pQuery->bindParam(':usuario', $usuario);
            $pQuery->execute();
            $pQuery->setFetchMode(PDO::FETCH_ASSOC);
            while ($game = $pQuery->fetch()) {
                $oGames->game_ty_id = $game['game_ty_id'];
                $oGames->game_ty_description = $game['game_ty_description'];
                $oGames->game_ty_level = $game['game_ty_level'];
                $oGames->game_ty_puntos = $game['game_ty_puntos'];
                $oGames->game_ty_records = $game['game_ty_records'];
                $oGames->game_ty_tiempo = $game['game_ty_tiempo'];
            }
            if ($oGames != null) {
                return $oGames;
            } else {
                return null;
            }
        }

        public function nivelMaximo(){
            $oGames = new Games();
            $conexion = conexionDB::conectar();
            $query = "SELECT MAX(game_ty_level) game_ty_level FROM game_type gt";
            $pQuery = $conexion->prepare($query);
            $pQuery->execute();
            $pQuery->setFetchMode(PDO::FETCH_ASSOC);
            while ($game = $pQuery->fetch()) {
                $oGames->game_ty_level = $game['game_ty_level'];
            }
            if ($oGames != null) {
                return $oGames;
            } else {
                return null;
            }
        }

        public function nivelMinimo(){
            $oGames = new Games();
            $conexion = conexionDB::conectar();
            $query = "SELECT game_ty_id, game_ty_description, game_ty_level, game_ty_puntos, game_ty_records, game_ty_tiempo FROM game_type gt WHERE gt.game_ty_level IN (SELECT MIN(t.game_ty_level) AS minimo FROM game_type t)";
            $pQuery = $conexion->prepare($query);
            $pQuery->execute();
            $pQuery->setFetchMode(PDO::FETCH_ASSOC);
            while ($game = $pQuery->fetch()) {
                $oGames->game_ty_id = $game['game_ty_id'];
                $oGames->game_ty_description = $game['game_ty_description'];
                $oGames->game_ty_level = $game['game_ty_level'];
                $oGames->game_ty_puntos = $game['game_ty_puntos'];
                $oGames->game_ty_records = $game['game_ty_records'];
                $oGames->game_ty_tiempo = $game['game_ty_tiempo'];
            }
            if ($oGames != null) {
                return $oGames;
            } else {
                return null;
            }
        }

        public function inserta($game_time, $game_ty_id, $user_user_id, $estado){
            $conexion = conexionDB::conectar();
            $query = "INSERT INTO game (game_time, game_ty_id, user_user_id, estado) VALUES (:game_time, :game_ty_id, :user_user_id, :estado)";
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':game_time', $game_time);
                $pQuery->bindParam(':game_ty_id', $game_ty_id);
                $pQuery->bindParam(':user_user_id', $user_user_id);
                $pQuery->bindParam(':estado', $estado);
                $pQuery->execute();
            }
            $query = "SELECT MAX(g.game_id) game_id FROM game g WHERE g.user_user_id = :user_user_id";
            $oGames = null;
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':user_user_id', $user_user_id);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($game = $pQuery->fetch()) {
                    $oGames = new Games();
                    $oGames->game_id = $game['game_id'];
                    $query = "UPDATE game SET estado = :estado WHERE game_id = :game_id";
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':estado', $game['game_id']);
                    $pQuery->bindParam(':game_id', $game['game_id']);
                    $pQuery->execute();
                }
                if ($oGames != null) {
                    return $oGames;
                } else {
                    return null;
                }
            }
        }

        public function insertaNivel($game_time, $game_ty_id, $user_user_id, $estado){
            $conexion = conexionDB::conectar();
            $query = "INSERT INTO game (game_time, game_ty_id, user_user_id, estado) VALUES (:game_time, :game_ty_id, :user_user_id, :estado)";
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':game_time', $game_time);
                $pQuery->bindParam(':game_ty_id', $game_ty_id);
                $pQuery->bindParam(':user_user_id', $user_user_id);
                $pQuery->bindParam(':estado', $estado);
                $pQuery->execute();
            }
            if ($pQuery) {
                return 200;
            } else {
                return 401;
            }
        }
    }

    class Game
    {
        public $game_id = 0;
        public $game_ty_id = 0;
        public $game_ty_description = "";
        public $game_ty_level = "";
        public $game_ty_puntos = "";
        public $game_ty_records = "";
        public $game_ty_tiempo = "";
    }
