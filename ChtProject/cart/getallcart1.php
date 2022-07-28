<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    $mysqli = new mysqli('localhost', 'root', '', 'finalproject', 3306);
    $mysqli->set_charset('utf8');

    spl_autoload_register(function($className) {
        require_once $className . '.php';
    });

    $sql = "SELECT * FROM carts";
    $result = $mysqli->query($sql);
    $dataArray = array();
    while ($carts = $result->fetch_object()){
        $dataArray[] = $carts;
    }
    $finalData = json_encode($dataArray);
    echo $finalData;

?>