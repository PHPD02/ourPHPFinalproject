<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    $mysqli = new mysqli('localhost', 'root', '', 'finalproject', 3306);
    $mysqli->set_charset('utf8');

    spl_autoload_register(function($className) {
        require_once $className . '.php';
    });

    $input = file_get_contents("php://input");
    $output = json_decode($input);
    // var_dump($output->data->id);
    echo($output->data->id);
    // $sqlid = $output->data->id;
    // $sqlid = 7008;
    
    // $sql = "SELECT * FROM `menu` WHERE restaurantId = $sqlid";
    

    
?>