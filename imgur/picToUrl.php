<?php
header('Access-Control-Allow-Origin: * ');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,PUT');
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With,X-PINGOTHER,Content-Type');

$IMGUR_CLIENT_ID = "7b9a0d0b0e036c5";

$file = $_FILES['image'];

$image_source = file_get_contents($file['tmp_name']);
$postFields = array('image' => base64_encode($image_source));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $IMGUR_CLIENT_ID));
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
$response = curl_exec($ch);

curl_close($ch);
$responseArr = json_decode($response);
if (!empty($responseArr->data->link)) {
    echo $responseArr->data->link;
} else {
    echo "error";
}
