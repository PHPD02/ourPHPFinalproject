<?php
include './serverHeader.php';
include('sql.php');
if ($_GET) {
  $address = $_GET['address'];
  echo $address;
  // $sql = "SELECT * FROM restaurants where Region = ?";
  $sql = "SELECT name , region , picture FROM restaurant where region = ? ";
  $stmt = $mysqli->prepare($sql);

  $stmt->bind_param('s', $address);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = array();
  if ($result) {
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_object()) {
        $data[] = $row;
      }
    }
  }

  $dataToClient = json_encode($data);
  echo $dataToClient;
} else {
  echo "No GET Request";
}