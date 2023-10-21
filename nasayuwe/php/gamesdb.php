<?php
   // Database Connection
   session_start();
   include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/games.php";
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
   $strQuery = "SELECT COUNT(*) AS allcount FROM game_type ";
   $conexion = $oConexion->conectar();
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM game_type WHERE 1 ".$searchQuery;
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $strQuery = "SELECT g.game_ty_id, g.game_ty_description, g.game_ty_level, g.game_ty_puntos, g.game_ty_records, g.game_ty_tiempo FROM game_type g WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
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
         "game_ty_id"=>$row['game_ty_id'],
         "game_ty_description"=>$row['game_ty_description'],
         "game_ty_level"=>$row['game_ty_level'],
         "game_ty_puntos"=>$row['game_ty_puntos'],
         "game_ty_records"=>$row['game_ty_records'],
         "game_ty_tiempo"=>$row['game_ty_tiempo']
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