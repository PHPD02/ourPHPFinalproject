<?php
    
    header('Access-Control-Allow-Origin: http://localhost:3000');
   
    $mysqli = new mysqli('localhost', 'root', '', 'finalproject', 3306);
    
    $mysqli->set_charset('utf8');
    
?>