<?php
include('serverHeader.php');
include('sql.php');
$sql = "SELECT * FROM orderdetails LIMIT 1";

$result = $mysqli->query($sql);


$dataArray = array();

while ($details = $result->fetch_object()) {
  // echo json_encode($carts);
  $dataArray[] = $details;
}
$Data = json_encode($dataArray);
echo $Data;