<?php
   // Database Connection
   session_start();
   include_once $_SERVER["DOCUMENT_ROOT"] . "/GameNasaYuwe/nasayuwe/php/usuario.php";
   $oConexion = new conexiondb();

   // Reading value
   $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value
   $searchByRol = $_POST['searchByRol'];
   $searchArray = array();
   $newArray = array();

   // Search
   $searchQuery = " ";
   if($searchByRol != ''){
      $searchQuery = " AND (user_ro_description LIKE :p_rol) ";
      $searchArray = array( 
         'p_rol'=>"%$searchByRol%"
      );
   }   
   if($searchValue != ''){
      $searchQuery = " AND (user_ro_description LIKE :rol ) ";
      $searchArray = array( 
           'rol'=>"%$searchValue%" );
   }

   // Total number of records without filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM user_role ";
   $conexion = $oConexion->conectar();
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM user_role WHERE 1 ".$searchQuery;
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $strQuery = "SELECT r.user_ro_id, r.user_ro_description FROM user_role r WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
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
         "user_ro_id"=>$row['user_ro_id'],
         "user_ro_description"=>$row['user_ro_description']
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