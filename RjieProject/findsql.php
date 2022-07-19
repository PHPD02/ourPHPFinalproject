<?php 
    include 'sql.php';
    spl_autoload_register(function($className){
        require_once $className . '.php';
    });

    $myquery = new MyQuery($mysqli);
    $name = $myquery->getProductData(124, MyQuery::QUERY_NAME);
    $tel = $myquery->getProductData(124, MyQuery::QUERY_TEL);
    $region = $myquery->getProductData(124,MyQuery::QUERY_REGION);
    echo "{$name}:{$tel}:{$region}<hr />";
    
    $allAddr = $myquery->getAllAddress('region like "{}"');
    foreach($allAddr as $address){
        echo "{$address->region}<br />";
    }
    echo '<hr />';
    $allData = $myquery->getDataByKeyword('86');
    foreach($allData as $data){
        echo "{$data->name} : {$data->tel} : {$data->region}<br />";
    }

?>