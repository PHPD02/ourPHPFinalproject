<?php
// Access-Control-Allow-Origin 跨來源資料共用
header('Access-Control-Allow-Origin:http://localhost:3000');
$mysqli = new mysqli('localhost','root','','finalproject',3306);
// mysqli 字元編碼設定
$mysqli->set_charset('utf8');
?>