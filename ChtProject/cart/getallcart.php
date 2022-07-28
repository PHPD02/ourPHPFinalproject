<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    $mysqli = new mysqli('localhost', 'root', '', 'finalproject', 3306);
    $mysqli->set_charset('utf8');

    spl_autoload_register(function($className) {
        require_once $className . '.php';
    });

    // var_dump($_GET['uid']);

    if($_GET){
        $sqluid = $_GET['uid'];
        //找出最新訂單編號
        $sql = "SELECT orderdetails.orderId FROM `orderdetails`
        LEFT JOIN `ordert` ON ordert.orderId = orderdetails.orderId
        LEFT JOIN restaurant ON ordert.restaurantId = restaurant.id 
        WHERE uId = {$sqluid} AND ordert.state = '未結帳'
        GROUP BY orderId DESC LIMIT 1";
        $result=$mysqli->query($sql);
        // echo($result->fetch_object()->orderId);
        $resultId = $result->fetch_object()->orderId;
        
        // 最新編號未結帳訂單
        $sql = 
        "SELECT * FROM `ordert` 
         LEFT JOIN `orderdetails` ON ordert.orderId = orderdetails.orderId
         LEFT JOIN restaurant ON ordert.restaurantId = restaurant.id 
         WHERE uId = {$sqluid} AND ordert.state = '未結帳' AND ordert.orderId = {$resultId}";
        // $sql = "SELECT * FROM `orderdetails` RIGHT JOIN `ordert` ON `ordert`.orderId = `orderdetails`.orderId WHERE uId = 12";
        $result=$mysqli->query($sql);

        $dataArray = array();
        while($dataa = $result->fetch_object()){
            $dataArray[] = $dataa;
        }
        // $dataa = $result->fetch_object();
        $data = json_encode($dataArray);
        echo ($data);
    }else{
        echo "Nothing to get";
    }

?>