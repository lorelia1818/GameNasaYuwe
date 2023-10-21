<?php
   // Database Connection
   session_start();
   include_once $_SERVER["DOCUMENT_ROOT"] . "/nasayuwe/php/usuario.php";
   $oConexion = new conexiondb();

   // Reading value
   $draw = $_POST['draw'];
   $row = $_POST['start'];
   $rowperpage = $_POST['length']; // Rows display per page
   $columnIndex = $_POST['order'][0]['column']; // Column index
   $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
   $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
   $searchValue = $_POST['search']['value']; // Search value
   $searchByUsuario = $_POST['searchByUsuario'];
   $searchByEdad = $_POST['searchByEdad'];
   $searchByRol = $_POST['searchByRol'];
   $searchArray = array();
   $newArray = array();

   // Search
   $searchQuery = " ";
   if($searchByUsuario != ''){
      $searchQuery = " AND (user_name LIKE :p_usuario) ";
      $searchArray = array( 
         'p_usuario'=>"%$searchByUsuario%"
      );
   }
   
   if($searchByEdad != ''){
      if($searchQuery != ''){
         $searchQuery = $searchQuery . " AND (user_age LIKE :p_edad) ";
         $newArray = array( 
            'p_edad'=>"%$searchByEdad%"
         );
         $searchArray = array_merge($searchArray, $newArray);
      }else{
         $searchQuery = " AND (user_age LIKE :p_edad) ";
         $searchArray = array( 
            'p_edad'=>"%$searchByEdad%"
         );
      }
   }

   if($searchByRol != ''){
      if($searchQuery != ''){
         $searchQuery = $searchQuery . " AND (user_role_user_ro_id = :p_rol) ";
         $newArray = array( 
            'p_rol'=>"$searchByRol"
         );
         $searchArray = array_merge($searchArray, $newArray);
      }else{
         $searchQuery = " AND (user_role_user_ro_id = :p_rol) ";
         $searchArray = array( 
            'p_rol'=>"$searchByRol"
         );
      }
   }
   if($searchValue != ''){
      $searchQuery = " AND (user_name LIKE :usuario OR 
           user_age LIKE :edad OR
           user_role_user_ro_id = :rol ) ";
      $searchArray = array( 
           'usuario'=>"%$searchValue%",
           'edad'=>"%$searchValue%",
           'rol'=>"$searchValue"
      );
   }

   // Total number of records without filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM usuario ";
   $conexion = $oConexion->conectar();
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM usuario WHERE 1 ".$searchQuery;
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $strQuery = "SELECT u.user_id, u.user_name, u.user_password, u.user_age, u.user_role_user_ro_id, (SELECT r.user_ro_description FROM user_role r WHERE r.user_ro_id = u.user_role_user_ro_id ) user_ro_description FROM usuario u WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
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
         "user_name"=>$row['user_name'],
         "user_password"=>$row['user_password'],
         "user_ro_description"=>$row['user_ro_description'],
         "user_age"=>$row['user_age'],
         "user_role_user_ro_id"=>$row['user_role_user_ro_id'],
         "user_id"=>$row['user_id']
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