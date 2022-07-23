<?php
if (isset($_POST["submit"])) {
    // 有無收到
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    $message = $_POST["message"];

    $errorEmpty = false;
    $errorEmail = false;
    $errorPass = false;


    // echo $name.'<br />';
    // echo $email.'<br />';
    // echo $pass1.'<br />';
    // echo $pass2.'<br />';
    // echo $message.'<br />';

    if (
        empty($name) || empty($email) || empty($pass1)
        || empty($pass2) || empty($message)
    ) {
        // empty是否為空  ||=>or 其中一個為空

        echo "<span class='form-error'>請輸入完整訊息</span>";
        $errorEmpty = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // 正規表達式的驗證方法  不符合正規表達式得出FALSE因此執行這句
        echo "<span class='form-error'>請輸入正確格式的郵箱地址</span>";
        $errorEmail = true;
    } elseif ($pass1 != $pass2) {
        echo "<span class='form-error'>確認密碼不符</span>";
        $errorPass = true;
    }else{
        $mailToname = "順弁株式會社";  //收件人名稱
        $mailTo = "bgkong1205@gmail.com" ; //收件信箱
        $mailFromname= $name;  //寄件人
        $mailFrom = $email;  //寄件人信箱
        $mailSubject = "相關客服案件" ; //主旨
        $mailContent ="姓名:" .$name."<br />" ."訊息內容:" .$message;
        
        if(mail($mailTo, $mailSubject, $mailContent, $mailFrom)){
            echo "<span class='form-success'>郵件成功送出</span>";
        }else{
            echo "<span class='form-error'>郵件發送失敗</span>";
        }
        // 判斷是否完成寄件
    }
} else {
    echo "<span class='form-error'>網路錯誤，請稍後再試</span>";
}
?>

<script>
    $("#email-name, #email-address, #pass1, #pass2, #mail-message").removeClass("input-error");

    var errorEmpty = "<?php echo $errorEmpty ?>"
    var errorEmail = "<?php echo $errorEmail ?>"
    var errorPass = "<?php echo $errorPass ?>"

    if (errorEmpty == true) {
        $("#email-name, #email-address, #pass1, #pass2, #mail-message").addClass("input-error");
    }
    if (errorEmail == true) {
        $("#email-address").addClass("input-error");
    }
    if (errorPass == true) {
        $("#pass1, #pass2").addClass("input-error");
    }
</script>