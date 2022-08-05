<?php
header('Access-Control-Allow-Origin: *');
include('../sql.php');
//include "db_func.php"; 
require_once 'ECPay.Payment.Integration.php';
 
// 將 post 資料轉成字串 儲存 SaveData
$String = print_r( $_POST, true );
//file_put_contents( 'tmp/ECPay.txt', $String, FILE_APPEND );
 
//writelogV1("tmp/log.txt" ,"ECPay_OrderResultURL.php======================");  
//writelogV1("tmp/log.txt" ,$String); 
 
 
define( 'ECPay_MerchantID', '2000132' );
define( 'ECPay_HashKey', '5294y06JbISpM5x9' );
define( 'ECPay_HashIV', 'v77hoKGq4kWxNNIS' );
 
// 重新整理回傳參數。
$arParameters = $_POST;
foreach ($arParameters as $keys => $value) {
    if ($keys != 'CheckMacValue') {
        if ($keys == 'PaymentType') {
            $value = str_replace('_CVS', '', $value);
            $value = str_replace('_BARCODE', '', $value);
            $value = str_replace('_CreditCard', '', $value);
        }
        if ($keys == 'PeriodType') {
            $value = str_replace('Y', 'Year', $value);
            $value = str_replace('M', 'Month', $value);
            $value = str_replace('D', 'Day', $value);
        }
        $arFeedback[$keys] = $value;
    }
}
 
// 計算出 CheckMacValue
$CheckMacValue = ECPay_CheckMacValue::generate( $arParameters, ECPay_HashKey, ECPay_HashIV );
 
// 必須要支付成功並且驗證碼正確
if ( $_POST['RtnCode'] =='1' && $CheckMacValue == $_POST['CheckMacValue'] ){
    // 
    // 要處理的程式放在這裡，例如將線上服務啟用、更新訂單資料庫付款資訊等
    // 
    // var_dump($_POST);
    $resultno = $_POST['MerchantTradeNo'];
    // $sql = "SELECT * FROM `ordert` WHERE orderId = '{$resultno}'";
    $sql = "UPDATE `ordert` SET `state`='已結帳，未收貨' WHERE `orderId`= $resultno";
    $result = $mysqli->query($sql);

    // 清空購物車
    $sql = "DROP TABLE IF EXISTS `carts`";
    $result = $mysqli->query($sql);
    // 重新建立購物車
    $sql = "CREATE TABLE `carts` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `menuItemId` int(11) NOT NULL,
        `restaurantName` varchar(135) NOT NULL,
        `restaurantId` int(11) NOT NULL,
        `dish` varchar(100) NOT NULL,
        `type` varchar(50) NOT NULL,
        `picture` varchar(600) DEFAULT NULL,
        `cost` int(11) NOT NULL,
        `mount` int(11) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4";
    $result = $mysqli->query($sql);

}

header("Location: http://localhost:3000/orderDetails");
 
// 接收到資訊回應ok
// echo 'OK!付款成功';