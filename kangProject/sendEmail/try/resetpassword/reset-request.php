<?php
    // 是否透過按鈕進入重設，而非直接透過網址，不是按按鈕的回首業

    if(isset($_POST["reset-requset-submit"])){

        // 允許訪問數據庫   8位的二進制隨機數再轉成16進制>>加倍安全
        $selector=bin2hex(random_bytes(8));

        //確認修改數據庫的用戶和收到我們重設信的是同一用戶，且確認是存在資料庫的用戶  安全性高一點
        $token = random_bytes(32);

        $url= "http://localhost/try/resetpassword/create-new-password.php?selector=".$selector."&validator=".bin2hex($token); 
        //存取資料庫的密碼和發送給用戶的密碼再次加密，避免駭客入侵資料庫也無從判別

        $expires=date("U")+60*30;  //date("U")是指用那個1970時間的把他換算成秒數計算到現在
        // 一次性token設定現在時間+30分鐘時效

        require "database_handler.php";

        $userEmail = $_POST["email"]; //導入忘記密碼頁載入的郵件

        // 重複申請重設密碼
        $sql = "DELETE FROM pwdreset WHERE pwdresetEmail =?";

        $statement = mysqli_stmt_init( $connection);  //先初始化

        if(!mysqli_stmt_prepare($statement,$sql)){
            //                  在$statement執行$sql
            echo "資料庫發生錯誤";
            exit();
        }else{
            mysqli_stmt_bind_param($statement,"s",$userEmail);
            // false的話就在        這        綁定為字串  的值
            // $userEmail是可以直接寫入pwdresetEmail =?，主要是為了避免駭客的反向入侵(忘記那叫啥 文字框輸入那個)
            mysqli_stmt_execute($statement);
            // 開始執行  這裡的$statement是已經完成  conn綁定連接 $sql 語句和 email輸入
        }


        $sql= "INSERT INTO pwdreset (pwdresetEmail, pwdresetSelector, pwdresetToken, pwdresetExpires) VALUES (?, ?, ?, ?)";
        $statement = mysqli_stmt_init( $connection);  //先初始化

        if(!mysqli_stmt_prepare($statement,$sql)){
            //                  在$statement執行$sql
            echo "資料庫發生錯誤";
            exit();
        }else{
            // $token再次加密 第二層防護
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);  //PHP自帶加密功能

            mysqli_stmt_bind_param($statement,"ssss",$userEmail ,$selector, $hashedToken, $expires);  //儲存再次加密的TOKEN
            // false的話就在        這        4個字串  4個值
            mysqli_stmt_execute($statement);
            // 開始執行  這裡的$statement是已經完成 以上工作
        }

        mysqli_stmt_close($statement); //完成後記得關閉
        mysqli_close($connection); //通道也要關閉


// 進行發送郵件
        $to = $userEmail;
        $subject = "重設您的密碼";
        $message = '<p style="color:red">請透過下方連結進入，並重設您的密碼啊!小笨蛋:<br />'; //裡面還包超連結，所以</P>下去
        $message .="<a href='" . $url . "'>" . $url . "</a></p>"; //   .=用法
        $header = "From : KangKang <kang@gmail.com> \r\n";
        $header .= "Reply-To : kang@gmail.com \r\n";
        $header .= "Content-Type : text/html \r\n";

        mail($to ,$subject, $message , $header);

        header ("Location: reset-password.php?reset=success"); // ?reset=success透過get變亮返還成功訊息


    }else{
        header("Location: index.php");
    }



?>