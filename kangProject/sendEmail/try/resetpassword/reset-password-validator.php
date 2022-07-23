<?php

    if(isset($_POST["reset-password-submit"])){ //是否送出申請

        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $password = $_POST["pwd"];
        $passwordRepeat = $_POST["pwd-repeat"];

        if(empty($password) || empty($passwordRepeat)){
            header("Location :create-new-password.php?newpwd=empty&selector=".$selector."&validator=".$validator);
            //                                       空密碼  就讓他重返重辦頁   依樣要提供兩個token
            exit();
        }elseif($password !== $passwordRepeat){
            header("Location :create-new-password.php?newpwd=pwdnotthesame&selector=".$selector."&validator=".$validator);
            //                                       兩次不一樣也重返重辦頁   
            exit();
        }

        require "database_handler.php";  //呼叫數據庫
        $currentDate = date("U"); //抓現在時間，因為我們有設置有效時間
        //1.確認selector 2.確認expires  3.確認validator(但這資料庫和get得到的值是不一樣的)

        $sql = "SELECT * FROM pwdreset WHERE pwdresetSelector=? AND pwdresetExpires>=?";
        $statement = mysqli_stmt_init($connection) ; //參照require "database_handler.php"
        if(!mysqli_stmt_prepare($statement,$sql)){ //沒有執行成功
            echo "資料庫連接失敗，請再次嘗試";
            exit();
        }else{  //執行查找參照 
            mysqli_stmt_bind_param($statement,"ss",$selector,$currentDate);
            mysqli_stmt_execute($statement);  //開始執行

            $result = mysqli_stmt_get_result($statement);  // 保存執行的結果
            if(!$row = mysqli_fetch_assoc($result)){
                //$row是固定用法不用管他  =裡面每一值
                echo "請重新提交您的重設密碼申請1";
                exit();
            }else{  //selector和expires有撈到後，再來處理validator
                $tokenBin = hex2bin($validator);  //我們在網址上有用bin2hex轉成16進位，但資料庫存的並沒有，因此再把他轉回2進位
                $tokenCheck = password_verify($tokenBin,$row["pwdresetToken"]);  //比對轉回2進位的和，剛剛fetch裡每一row，欄位是pwdresetToken的值
                if($tokenCheck ==false){
                    echo "請重新提交您的重設密碼申請2";
                    exit();
                }elseif($tokenCheck ===true){  //對的話就拉出email去使用者table開始比對    後再置換
                    $tokenEmail = $row["pwdresetEmail"];
                    $sql ="SELECT * FROM users WHERE userEmail=?";  //換表

                    // 慣例操作
                    $statement = mysqli_stmt_init($connection);
                    
                    if(!mysqli_stmt_prepare($statement,$sql)){
                        echo "資料庫連接失敗，請再次嘗試";
                        exit();
                    }else{
                        mysqli_stmt_bind_param($statement,"s",$tokenEmail); //透過綁定的參數去尋找
                        mysqli_stmt_execute($statement);
                        $result = mysqli_stmt_get_result($statement);

                        if(!$row = mysqli_fetch_assoc($result)){
                            echo "請重新提交您的重設密碼申請3";
                            exit();

                        }else{  //開始更新密碼
                            $sql = "UPDATE users SET pwd =? WHERE userEmail=?";
                            $statement = mysqli_stmt_init($connection);

                            if(!mysqli_stmt_prepare($statement,$sql)){
                                echo "資料庫連接失敗，請再次嘗試";
                                exit();
                            }else{
                                $newpwdHash = password_hash($password,PASSWORD_DEFAULT);   //重新製作hash密碼加入
                                mysqli_stmt_bind_param($statement,"ss",$newpwdHash,$tokenEmail); //把這兩個值作為參數去執行
                                mysqli_stmt_execute($statement);



                                $sql = "DELETE FROM pwdreset WHERE pwdresetEmail=?";  //更信密碼完成後，再把重設資料表的內容刪除
                                $statement = mysqli_stmt_init($connection);

                                if(!mysqli_stmt_prepare($statement,$sql)){
                                    echo "資料庫連接失敗，請再次嘗試";
                                    exit();
                                }else{
                                    mysqli_stmt_bind_param($statement,"s",$tokenEmail); //把這個值作為參數去執行
                                    mysqli_stmt_execute($statement);
                                    header("Location: index.php?newpwd=passwordUpdated");
                                 }                  
                            }
                        }

                    }
                }
            }
        }





    }else{
        header("Location : index.php");
    }







 

?>