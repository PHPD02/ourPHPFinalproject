<?php
           
    if(isset($_SESSION["userId"])){
        echo '<p class="login.php">您已經完成登入</P>';
    }else{
        echo '<p class="logout.php">您已登出系統.<a href="reset-password.php">忘記密碼</a></P>';


        //所有忘記密碼流程結束後回到這一頁，再透過get變量的回傳  newpwd=passwordUpdated
        if(isset($_GET["newpwd"])){
            if($_GET["newpwd"] === "passwordUpdated"){
                echo '<p style="color:red">您的密碼已重置，請再次登入</p>';
            }
        }



    }



?>
