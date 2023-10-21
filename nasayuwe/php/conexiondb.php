<?php
   class conexionDB
   {
      public $usuarioDB='root';
      public $passDB='root';
      public $ipDB='127.0.0.1:3308';
      public $nombreDB='interactivegame_nasayuwe';
      public $link = null;
      private $stmt;
      private $array;
      static $_instance;
   
      /*La función construct es privada para evitar que el objeto pueda ser creado mediante new*/
      public function __construct(){
         $this->conectar();
      }
   
      /*Evitamos el clonaje del objeto. Patrón Singleton*/
      private function __clone(){ }
   
      /*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
      public static function getInstance(){
         if (!(self::$_instance instanceof self)){
            self::$_instance=new self();
         }
         return self::$_instance;
      }
   
      /*Realiza la conexión a la base de datos.*/
      public function conectar(){
         try{
               $link = new PDO("mysql:host=" . $this->ipDB . ";dbname=" . $this->nombreDB, $this->usuarioDB, $this->passDB);
               $link->exec("set names utf8");
               //echo "Connected successfully";
               return $link;
         } catch (PDOException $e) {
               echo "Failed to get DB handle: " . $e->getMessage();
               die();
         }
      }
   
      /*Método para ejecutar una sentencia sql*/
      public function ejecutar($sql){
         //echo $sql;
         $link = conexionDB::conectar();
         $stmt = $link->prepare($sql);
         $stmt->execute();
         return $stmt;
      }
   
      /*Método para obtener una fila de resultados de la sentencia sql*/
      public function obtener_fila($stmt,$fila){
         if ($fila==0){
            $this->array=mysql_fetch_array($stmt);
         }else{
            mysql_data_seek($stmt,$fila);
            $this->array=mysql_fetch_array($stmt);
         }
         return $this->array;
      }
   
      //Devuelve el último id del insert introducido
      public function lastID(){
         return mysql_insert_id($this->link);
      }
   
   }