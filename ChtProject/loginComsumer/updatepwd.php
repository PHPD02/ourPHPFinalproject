<?php
    header('Access-Control-Allow-Origin: http://localhost:3000');
    include("../sql.php");

    $realpwd = '@Aa12345';
    $password = password_hash($realpwd, PASSWORD_DEFAULT);

    $sql = "UPDATE `usermember` SET `password` = '{$password}' WHERE uid = 12;";
    $result = $mysqli->query($sql);
    echo $result;
?>