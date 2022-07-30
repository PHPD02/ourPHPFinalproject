
<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
    $mysqli = new mysqli('localhost', 'root', '', 'finalproject', 3306);
    $mysqli->set_charset('utf8');

    spl_autoload_register(function($className) {
        require_once $className . '.php';
    });

    // var_dump($_GET);

    // if($_GET){
        $email = $_GET['email'];
        // $email = 'drama3fu@gmail.com';
        // $sql = "SELECT * FROM proposal WHERE emailPartyA = '{$email}'";
        // $sql = "SELECT * FROM proposal WHERE emailPartyA = 'drama3fu@gmail.com'";
        $sql = "SELECT * FROM `sunsua_order` 
        LEFT JOIN proposal ON sunsua_order.proposalId = proposal.id 
        WHERE emailPartyB = '{$email}'
        ORDER BY sunsua_order.id DESC";
        $result = $mysqli->query($sql);
        $result->fetch_object();
        // var_dump($result);
        echo(json_encode($result->fetch_object()));

        // echo $result;
        // $result->fetch_object();
        // var_dump($result);
        // echo($result->shop);
    // }
    // proposal. cost*sunsua_order.count+sunsua_order.freight
?>