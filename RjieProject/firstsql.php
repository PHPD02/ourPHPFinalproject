<?php

include('sql.php');

$sql = "SELECT * FROM `restaurant` LIMIT 9";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_object()) {
    $data[] = $row;
  }
}
$dataToClient = json_encode($data, JSON_UNESCAPED_UNICODE);
echo $dataToClient;