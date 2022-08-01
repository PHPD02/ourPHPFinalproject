<?php
    header('Access-Control-Allow-Origin: *');
    $mysqli = new mysqli('localhost', 'root', '', 'finalproject', 3306);
    $mysqli->set_charset('utf8');

    $sql = "DROP TABLE IF EXISTS `carts`";
    $result = $mysqli->query($sql);

    $sql = "CREATE TABLE `carts` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `menuItemId` int(11) NOT NULL,
        `restaurantName` varchar(135) NOT NULL,
        `restaurantId` int(11) NOT NULL,
        `dish` varchar(100) NOT NULL,
        `type` varchar(50) NOT NULL,
        `picture` varchar(600) DEFAULT NULL,
        `cost` int(11) NOT NULL,
        `mount` int(11) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4";
    $result = $mysqli->query($sql);
    echo $result;
?>