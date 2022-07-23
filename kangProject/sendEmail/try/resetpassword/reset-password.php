<!-- 
<?php

    if($_POST['submit']){
        if(!$_POST['email'])$error.="<br />請輸入電子郵箱";
        else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))$error.="<br />請輸入正確的電子郵件";
        if(!$_POST['password'])$error.="<br />請輸入密碼 ";
        else{
            if(strlen($_POST['password'])<8)$error.="<br />請輸入8個字元以上";
            if(!preg_match('`[A-Z]`',$POST['password']))$error.='<br />請輸入至少一個大寫字母';
        }
        if($error) echo "註冊資訊有誤:".$error;
        //確認註冊資訊
        else{
            //上傳數據庫比對
            $link = 
            mysqli_connect("localhost","alexkang_alexkang","大小短底","alexkang_sql1practice");
            $query = "SELECT * FROM users WHERE email=".mysqli_real_escape_string($link,$_POST['email'])."'";
            // 避免再輸入框被反向入侵的方法
        }
    }



?>


<form method="post">
    <input type="email" name="email" id="email" />
    <input type="password" name="password" id="password" />
    <input type="submit" name="submit" value="sign up" />

</form> -->


<main class="reset-password-form">
    <h1>重置密碼</h1>
    <p>將發送重置密碼至您信箱</p>
    <form  
    action='reset-request.php' method='post'>
        <input type="text" name="email" placeholder="請輸入您的電子郵件">
        <button type="submit" name="reset-requset-submit">透過電子郵件重設您的密碼</button>

    </form>

    <?php
        if(isset($_GET["reset"])){  //  ?reset=success (從reset-request那邊)反向寫法 從那邊回傳確認是否有送出信件
            if($_GET["reset"] == "success"){
                echo '<p > 請您查收電子郵件啦</p>';
            }
        }

    
    ?>




</main>