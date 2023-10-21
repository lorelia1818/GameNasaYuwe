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
   $searchByWord = $_POST['searchByWord'];
   $searchByMeaning = $_POST['searchByMeaning'];
   $searchArray = array();
   $newArray = array();

   // Search
   $searchQuery = " ";
   if($searchByWord != ''){
      $searchQuery = " AND (word_description LIKE :p_word) ";
      $searchArray = array( 
         'p_word'=>"%$searchByWord%"
      );
   }
   
   if($searchByMeaning != ''){
      if($searchQuery != ''){
         $searchQuery = $searchQuery . " AND (word_spanish_meaning LIKE :p_meaning) ";
         $newArray = array( 
            'p_meaning'=>"%$searchByMeaning%"
         );
         $searchArray = array_merge($searchArray, $newArray);
      }else{
         $searchQuery = " AND (word_spanish_meaning LIKE :p_meaning) ";
         $searchArray = array( 
            'p_meaning'=>"%$searchByMeaning%"
         );
      }
   }

   if($searchValue != ''){
      $searchQuery = " AND (word_description LIKE :word OR 
           word_spanish_meaning LIKE :meaning) ";
      $searchArray = array( 
           'word'=>"%$searchValue%",
           'meaning'=>"%$searchValue%"
      );
   }

   // Total number of records without filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM words ";
   $conexion = $oConexion->conectar();
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute();
   $records = $stmt->fetch();
   $totalRecords = $records['allcount'];

   // Total number of records with filtering
   $strQuery = "SELECT COUNT(*) AS allcount FROM words WHERE 1 ".$searchQuery;
   $stmt = $conexion->prepare($strQuery);
   $stmt->execute($searchArray);
   $records = $stmt->fetch();
   $totalRecordwithFilter = $records['allcount'];

   // Fetch records
   $strQuery = "SELECT w.word_id, w.word_description, w.word_spanish_meaning, w.word_sound, w.word_play, w.word_graph, w.nomFoto FROM words w WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset";
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
         "word_id"=>$row['word_id'],
         "word_description"=>$row['word_description'],
         "word_spanish_meaning"=>$row['word_spanish_meaning'],
         "word_sound"=>$row['word_sound'],
         "word_play"=>$row['word_play'],
         "word_graph"=>$row['word_graph'],
         "nomFoto"=>$row['nomFoto']
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