<?php
include('serverHeader.php');
include('sql.php');
$mysqli->set_charset('utf8');
//抓資料 先找到 最新一筆的 orderId
$sql = "SELECT *,ROW_NUMBER() OVER(ORDER BY orderId DESC) sn FROM orderdetails LIMIT 1";
$result = $mysqli->query($sql);
$dataArray = array();

while ($details = $result->fetch_object()) {
  $dataArray = $details;
}
// 最新流水號 
// echo $dataArray->orderId . '<br />'; 
$orderId = $dataArray->orderId;
//------------------------------------------
// $dataArray["orderId"];
$sql = "SELECT dish,amount,cost,(amount*cost)as sum FROM orderdetails WHERE orderId = $orderId";
$result = $mysqli->query($sql);
$dataArray = array();
$sum = 0;
while ($details = $result->fetch_object()) {
  $dataArray[] = $details;
}
// print_r($dataArray);
foreach ($dataArray as $k => $d) {
  $sum += $d->sum;
  // echo $k.'<br />';
}


// echo $sum;
$r = [
  'water'=> $orderId,
  'menu' => $dataArray,
  'sums' => $sum
];
// print_r($test); 
// echo $test.'<br />';
$Data = json_encode($r);
echo $Data;
// print_r( $dataArray);
// 品項
// 產品(dish) 數量(amount) 金額(cost) 加總金額(sum)
// $Data = json_encode($dataArray);

// echo $Data;