
<?php
    header('Access-Control-Allow-Origin:*');

    $selector = $_GET["selector"];
    $validator = $_GET["validator"];
    $url= "http://localhost:3000/resetpassword?selector=".$selector."&validator=".$validator; 



    if(empty($selector) || empty($validator)){ //1.是否為空

        echo "無法驗證您的連結請重新嘗試";
    }else{
        if(ctype_xdigit($selector) !=false  && ctype_xdigit($validator) !=false){
            //少用，用來判斷是否為16個字元

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
                    }else{
                        header("Location:" .$url);
                        // var_dump( $row);

                    }
            


        }
        }
    }




?>
