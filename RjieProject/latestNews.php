<?php
  include('sql.php');
  $sql = "SELECT * FROM `news` WHERE 1";
  // echo $sql;
  $stmt = $mysqli->prepare($sql);
  // echo $sql;
  $stmt->execute();

  $result =$stmt->get_result();

  // var_dump($result);
  $data = array();
  if($result->num_rows > 0){
    while ($row = $result->fetch_object()){
      $data[] = $row;    
    }
  }
  $dataToClient = json_encode($data, JSON_UNESCAPED_UNICODE);
  echo $dataToClient;
?>