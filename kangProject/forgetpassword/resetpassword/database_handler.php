<?php
    $servername="localhost";
    $dbusername="root";
    $dbpassword="";
    $dbname="finalproject";

    $connection = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);

    if(!$connection){
        // echo"沒聯上喔"
        die("連結數據庫失敗".mysqli_connect_error());
    }


?>