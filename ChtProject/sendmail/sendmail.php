<?php
header('Access-Control-Allow-Origin: http://localhost:3000');

if (!isset($_POST['sendmail'])) echo -1;
$sendmail = $_POST['sendmail'];

// 驗證碼產生
$s = "";
for ($i = 1; $i <= 4; $i ++){
   $e = floor(rand(1,9));
   $s = $s . $e;
}
$chkNumber = $s;


// The message
$message = "驗證碼是\r\n". $chkNumber;

// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");
// $mailFrom = 'sunsuarestaurant0809@gmail.com';

$headers = "From: sunsuarestaurant0809@gmail.com";

// Send
mail($sendmail, '順弁餐飲外送股份有限公司', $message ,$headers, 'From:sunsuarestaurant0809@gmail.com');
// mail('drama3fu@gmail.com', 'My Subject', $message);

echo $chkNumber;
?>