<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/sesion.php";

    class Words extends Sesion
    {
        public function __construct()
        {
            parent::__construct();
            $this->sesion = null;
        }

        public function listado()
        {
            $query = "SELECT w.word_id, w.word_description, w.word_spanish_meaning, w.word_sound, w.word_play, w.word_graph FROM words w ORDER BY 2";
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                return $pQuery;
            }
        }

        public function listar($nivel, $p_usuario){
            //$query = "SELECT * FROM ((SELECT CONCAT(CONVERT(word_id, CHAR),'A') AS word_id, word_description, word_sound, word_play, word_graph, nomFoto FROM words x LIMIT :nivel) UNION (SELECT CONCAT(CONVERT(word_id, CHAR),'B') AS word_id, word_spanish_meaning, word_sound, word_play, word_graph, nomFoto FROM words w LIMIT :nivel)) Y ORDER BY RAND()";
            $conexion = conexionDB::conectar();
            $query = "DELETE FROM wordsGame WHERE usuario =:usuario";
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':usuario', $p_usuario);
                $pQuery->execute();
            }
            $query = "SELECT word_id FROM words x ORDER BY RAND() LIMIT :nivel";
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindValue(':nivel', (int)$nivel, PDO::PARAM_INT);
                return $pQuery;
            }
        }

        public function listas($word_id){
            $query = "SELECT word_id, word_description, word_spanish_meaning, word_sound, word_play, word_graph, nomFoto FROM words x WHERE x.word_id = :word_id";
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindValue(':word_id', (int)$word_id, PDO::PARAM_INT);
                return $pQuery;
            }
        }

        public function lista($word_id){
            $query = "SELECT w.word_id, w.word_description, w.word_spanish_meaning, w.word_sound, w.word_play, w.word_graph, w.nomFoto FROM words w WHERE word_id = :word_id";
            $oWords = null;
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindValue(':word_id', (int)$word_id, PDO::PARAM_INT);
                $pQuery->execute();
                $pQuery->setFetchMode(PDO::FETCH_ASSOC);
                while ($rol = $pQuery->fetch()) {
                    $oWords = new Words();
                    $oWords->word_id = $rol['word_id'];
                    $oWords->word_description = $rol['word_description'];
                    $oWords->word_spanish_meaning = $rol['word_spanish_meaning'];
                    $oWords->word_sound = $rol['word_sound'];
                    $oWords->word_play = $rol['word_play'];
                    $oWords->word_graph = $rol['word_graph'];
                    $oWords->nomFoto = $rol['nomFoto'];
                }
                if ($oWords != null) {
                    return $oWords;
                } else {
                    return null;
                }
            }
        }

        public function insertar($word_id, $word_description, $word_spanish_meaning, $word_sound, $word_play, $word_graph){
            $conexion = conexionDB::conectar();
            $strQuery = "SELECT COUNT(*) AS allcount FROM words WHERE word_description = :word_description";
            $stmt = $conexion->prepare($strQuery);
            $stmt->bindParam(':word_description', $word_description);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];
            if ($totalRecordwithFilter == 0){
                $query = "INSERT INTO words (word_description, word_spanish_meaning, word_sound, word_play, word_graph) VALUES (:word_description, :word_spanish_meaning, :word_sound, :word_play, :word_graph)";
                $oRoles = null;
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':word_description', $word_description);
                    $pQuery->bindParam(':word_spanish_meaning', $word_spanish_meaning);
                    $pQuery->bindParam(':word_sound', $word_sound);
                    $pQuery->bindParam(':word_play', $word_play);
                    $pQuery->bindParam(':word_graph', $word_graph);
                    $pQuery->execute();
                }
            }else{
                $query = "UPDATE words SET word_description = :word_description, word_spanish_meaning = :word_spanish_meaning, word_sound = :word_sound, word_play = :word_play, word_graph = :word_graph WHERE word_id = :word_id";
                $oListado = null;
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':word_description', $word_description);
                    $pQuery->bindParam(':word_spanish_meaning', $word_spanish_meaning);
                    $pQuery->bindParam(':word_sound', $word_sound);
                    $pQuery->bindParam(':word_play', $word_play);
                    $pQuery->bindParam(':word_graph', $word_graph);
                    $pQuery->bindParam(':word_id', $word_id);
                    $pQuery->execute();
                }
            }
            if ($pQuery) {
                return 200;
            } else {
                return 401;
            }
        }

        public function inserta($word_id, $word_description, $word_spanish_meaning, $word_sound, $word_play, $word_graph, $fileName, $fileContent){
            $conexion = conexionDB::conectar();
            $strQuery = "SELECT COUNT(*) AS allcount FROM words WHERE word_description = :word_description";
            $stmt = $conexion->prepare($strQuery);
            $stmt->bindParam(':word_description', $word_description);
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];
            if ($totalRecordwithFilter == 0){
                $query = "INSERT INTO words (word_description, word_spanish_meaning, word_sound, word_play, word_graph, nomfoto, foto) VALUES (:word_description, :word_spanish_meaning, :word_sound, :word_play, :word_graph, :nomfoto, :foto)";
                $oRoles = null;
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':word_description', $word_description);
                    $pQuery->bindParam(':word_spanish_meaning', $word_spanish_meaning);
                    $pQuery->bindParam(':word_sound', $word_sound);
                    $pQuery->bindParam(':word_play', $word_play);
                    $pQuery->bindParam(':word_graph', $word_graph);
                    $pQuery->bindParam(':nomfoto', $fileName);
                    $pQuery->bindParam(':foto', $fileContent, PDO::PARAM_LOB);
                $pQuery->execute();
                }
            }else{
                $query = "UPDATE words SET word_description = :word_description, word_spanish_meaning = :word_spanish_meaning, word_sound = :word_sound, word_play = :word_play, word_graph = :word_graph, nomfoto = :nomfoto, foto = :foto WHERE word_id = :word_id";
                $oListado = null;
                if ($conexion) {
                    $pQuery = $conexion->prepare($query);
                    $pQuery->bindParam(':word_description', $word_description);
                    $pQuery->bindParam(':word_spanish_meaning', $word_spanish_meaning);
                    $pQuery->bindParam(':word_sound', $word_sound);
                    $pQuery->bindParam(':word_play', $word_play);
                    $pQuery->bindParam(':word_graph', $word_graph);
                    $pQuery->bindParam(':nomfoto', $fileName);
                    $pQuery->bindParam(':foto', $fileContent, PDO::PARAM_LOB);
                    $pQuery->bindParam(':word_id', $word_id);
                    $pQuery->execute();
                }
            }
            if ($pQuery) {
                return 200;
            } else {
                return 401;
            }
        }

        public function insertGame($p_word_id, $p_word_description, $p_usuario){
            $conexion = conexionDB::conectar();
            $query = "INSERT INTO wordsGame (word_id, word_description, usuario) VALUES (:word_id, :word_description, :usuario)";
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':word_id', $p_word_id);
                $pQuery->bindParam(':word_description', $p_word_description);
                $pQuery->bindParam(':usuario', $p_usuario);
                $pQuery->execute();
            }
            if ($pQuery) {
                return 200;
            } else {
                return 401;
            }
        }

        public function listGame($p_usuario){
            $query = "SELECT word_id, word_description, usuario FROM wordsGame x WHERE usuario = :usuario ORDER BY RAND()";
            $conexion = conexionDB::conectar();
            if ($conexion) {
                $pQuery = $conexion->prepare($query);
                $pQuery->bindParam(':usuario', $p_usuario);
                return $pQuery;
            }
        }

    }

    class Word
    {
        public $word_id = 0;
        public $word_description = "";
        public $word_spanish_meaning = "";
        public $word_sound = "";
        public $word_play = "";
        public $word_graph = "";
        public $nomFoto = "";

    }
