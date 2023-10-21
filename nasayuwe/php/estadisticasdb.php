<?php
   // Database Connection
   session_start();
   include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/games.php";
   $oConexion = new conexiondb();

   // Reading value
   $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value
   $searchArray = array();
   $newArray = array();

   // Search
   $searchQuery = " ";

   // Total number of records without filtering
   $strQuery = "SELECT COUNT(DISTINCT u.user_name, CAST(g.game_time AS DATE), g.estado) AS allcount FROM game g, usuario u, game_type t WHERE g.user_user_id = u.user_id AND g.game_ty_id = t.game_ty_id";
   $conexion = $oConexion->conectar();
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $strQuery = "SELECT COUNT(DISTINCT u.user_name, CAST(g.game_time AS DATE), g.estado) AS allcount FROM game g, usuario u, game_type t WHERE g.user_user_id = u.user_id AND g.game_ty_id = t.game_ty_id ".$searchQuery;
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $strQuery = "SELECT 	CAST(g.game_time AS DATE) fecha, u.user_name usuario, g.estado, SUM(t.game_ty_puntos) puntos FROM game g, usuario u, game_type t WHERE g.user_user_id = u.user_id AND	g.game_ty_id = t.game_ty_id GROUP BY u.user_name, CAST(g.game_time AS DATE), g.estado ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
   $stmt = $conexion->prepare($strQuery);
   // Bind values
   foreach ($searchArray as $key=>$search) {
      $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
   }

   if ($rowperpage > 0){
      $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
      $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   }else{
      $rowperpage = 1000000;
      $stmt->bindValue(':limit', 1, PDO::PARAM_INT);
      $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
   }
   $stmt->execute();
   $listRecords = $stmt->fetchAll();
   $data = array();
   foreach ($listRecords as $row) {
      $data[] = array(
         "fecha"=>date("d-m-Y", strtotime($row['fecha'])),
         "usuario"=>$row['usuario'],
         "estado"=>$row['estado'],
         "puntos"=>$row['puntos']
      );
   }

   // Response
   $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "data" => $data
   );

   echo json_encode($response);