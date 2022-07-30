<?php
// 引入抬頭
include('serverHeader.php');
include('sql.php');
// LIKE 臺中市的店家 ORDER BY RAND()亂數 
if($_GET){
  $addr = $_GET['address'];
  // echo $addr;
  $sql = "SELECT id,name,region,description,picture FROM restaurant WHERE  region = ?   ORDER BY id LIMIT 9";
  // 資料準備
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param('s',$addr);
  // 資料執行
  $stmt->execute();
  // 取得拿取到的結果
  $result = $stmt->get_result();
  // var_dump($result);
  $data = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
      $data[] = $row;
    }
  }
  $dataToClient = json_encode($data, JSON_UNESCAPED_UNICODE);
  echo $dataToClient;
}