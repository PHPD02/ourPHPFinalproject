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
        GROUP BY orderId LIMIT 1";
        $result=$mysqli->query($sql);
        // echo($result->fetch_object()->orderId);
        $resultId = $result->fetch_object()->orderId;
        
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

    // $input = file_get_contents("php://input");
    // $output = json_decode($input);
    // $sqlId = $output->menuItemId;

    // var_dump($output);
    
    // var_dump($output);

    // $data = array();
    // $data = $_GET;

    // var_dump($data);
    



    // $sql = "SELECT * FROM carts";

    // $result = $mysqli->query($sql);
    // // $data = $result->fetch_object();

    // $dataArray = array();

    // while ($carts = $result->fetch_object()){
    //     $dataArray[] = $carts;
        

    //     // echo json_encode($carts);
    //     // var_dump($carts);
    // }
    // $fData = json_encode($dataArray);
    // echo $fData;




    // $finalData = json_encode($dataArray);
    // echo $finalData;

?>