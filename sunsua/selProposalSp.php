<?php

/**
 * TODO: 有時間 
 * 請改寫成 地址 餐點 或 類型 
 * 不要全都keyword
 *  
 */
// header('Access-Control-Allow-Origin: * ');
// // header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
// header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With,X-PINGOTHER,Content-Type');
date_default_timezone_set('Asia/Taipei');
include "../serverHeader.php";
include "../sql.php";
if ($_GET) {

    $keyword = "%{$_GET['keyword']}%";
    // $meal = "%{$_GET['meal']}%";
    $sql =  "   SELECT * 
                FROM (
                    proposal LEFT JOIN ( SELECT email,firstName,lastName FROM usermember) AS A
                    ON proposal.emailPartyA = email
                    ) 
                WHERE state = 1 and (addr LIKE ? or meal LIKE ?)
                ORDER BY arriveTime ASC;";
    // echo $sql;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $keyword, $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                $row->limitTime = limitTime_strtoTime($row->limitTime);
                $row->setTime = strtotime($row->setTime); // 出來是sec
                $row->setTime = $row->setTime * 1000; // 轉換成ms
                $data[] = $row;
            }
        }
    }

    $dataToClient = json_encode($data);
    echo $dataToClient;
} else {
    echo "No Get Request";
}
/* function */

function limitTime_strtoTime($str)
{
    $NewString = explode(":", $str, 3);
    $hr = $NewString[0];
    $min = $NewString[1];
    $sec = $NewString[2];
    $ms = ($hr * 3600 + $min * 60 + $sec) * 1000;
    return $ms;
}
