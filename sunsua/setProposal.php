<?php
// header('Access-Control-Allow-Origin: *');
// // header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
// header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With,X-PINGOTHER,Content-Type');
include "../serverHeader.php";
include "../sql.php";

$restJson = file_get_contents("php://input");
$_POST = json_decode($restJson, true);
if ($_POST) {
    $emailPartyA = $_POST['emailPartyA'];
    $addr = $_POST['city'] . $_POST['area'] . $_POST['addr'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $arriveTime = $_POST['arriveTime'];
    $shop = $_POST['shop'];
    $meal = $_POST['meal'];
    $cost = $_POST['cost'];
    $amount = $_POST['amount'];
    $mealType = $_POST['mealType'];
    $limitTimeHr = $_POST['limitTimeHr'];
    $freight = $_POST['freight'];
    $limitTimeMin = $_POST['limitTimeMin'];
    $picUrl = $_POST['picUrl'];

    $limitTime = $limitTimeHr . ":" . $limitTimeMin . ":00";
    $state = 1;

    $sql = "INSERT INTO proposal 
            (id, emailPartyA, addr, city, area, arriveTime, shop, meal, cost, amount, mealType, setTime, limitTime, freight ,picUrl,state) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), ?, ?, ?, 1 );";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
        'sssssssssssss',
        $emailPartyA,
        $addr,
        $city,
        $area,
        $arriveTime,
        $shop,
        $meal,
        $cost,
        $amount,
        $mealType,
        $limitTime,
        $freight,
        $picUrl,
    );
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        echo $result;
    } else {
        echo "no result";
    }
} else {
    echo ("NO POST<br/>\n");
}
