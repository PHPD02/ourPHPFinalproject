
<main class="signup-form">


<?php
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if(empty($selector) || empty($validator)){ //1.是否為空

        echo "無法驗證您的連結請重新嘗試";
    }else{
        if(ctype_xdigit($selector) !=false  && ctype_xdigit($validator) !=false){
            //少用，用來判斷是否為16個字元

            //中間再夾一個php 
            ?> 


            <form class="" action="reset-password-validator.php" method="post">
                <!-- 兩個token先設置為隱藏，把它變成表單一童送出去驗正 -->
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <input type="password" name="pwd" placeholder="請輸入密碼">
                <input type="password" name="pwd-repeat" placeholder="請再次輸入密碼">
                <button type="submit" name="reset-password-submit">重設密碼</button>

            </form>



            <?php


        }
    }




?>

</main>