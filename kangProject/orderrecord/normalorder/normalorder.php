<?php
include "../serverHeader.php";
include "../sql.php";

$sql = ' SELECT * FROM ((
    (usermember Left JOIN ordert ON usermember.uid = ordert.uid)
    LEFT JOIN orderdetails ON ordert.orderId = orderdetails.orderId) 
    LEFT JOIN restaurant ON ordert.restaurantId = restaurant.id)
    WHERE usermember.email = ?';
if ($_GET) {
    $email = $_GET['email'];
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // class Usermember
    // {
    //     var $uid;
    //     var $email;
    //     var $firstName;
    //     var $lastName;

    // }
    class Ordert
    {
        var $orderId;
        var $restaurantId;
        var $cost;
        var $freight;
        var $picture;
        var $OrderDetail = [];
    };
    class OrderDetails
    {
        var $odId;
        var $dish;
        var $amount;
        var $cost;
    }

    $dataToClient = array();
    $data = [];
    $i=0;
    if ($result) {
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_object()) {
                // echo $row->proposalId . ":" . $row->id . "<br/>\n";

                if (count($dataToClient) == 0) {
                    // echo "第一次<br/>\n";

                    $oderData = new OrderDetails;
                    $oderData->odId = $row->odId;
                    $oderData->dish = $row->dish;
                    $oderData->amount = $row->amount;
                    $oderData->cost = $row->cost;

                    $data = new Ordert;
                    $data->orderId = $row->orderId;
                    $data->restaurantId = $row->restaurantId;
                    $data->cost = $row->cost;
                    $data->freight = $row->freight;
                    $data->picture = $row->picture;
                    array_push($data->OrderDetail, $oderData);
                    array_push($dataToClient, $data);
                } else {
                    $i = 0;
                    for ($i; $i < count($dataToClient); $i++) {
                        // echo "count(dataToClient) => " . count($dataToClient) . "<br/>\n";
                        // echo "proposalId : rowid => " . $dataToClient[$i]->proposalId . ":" . $row->id . "<br/>\n";
                        if ($dataToClient[$i]->orderId == $row->orderId) {
                            // echo "有這個proposal id了<br/>\n";
                            $oderData = new OrderDetails;
                            $oderData->odId = $row->odId;
                            $oderData->dish = $row->dish;
                            $oderData->amount = $row->amount;
                            $oderData->cost = $row->cost;

                            array_push($dataToClient[$i]->OrderDetail, $oderData);
                            break;
                        } else {
                            // echo "沒有這個proposal id，請建立新的<br/>\n";
                        }
                    }
                    if ($i == count($dataToClient)) {
                    $oderData = new OrderDetails;
                    $oderData->odId = $row->odId;
                    $oderData->dish = $row->dish;
                    $oderData->amount = $row->amount;
                    $oderData->cost = $row->cost;

                    $data = new Ordert;
                    $data->orderId = $row->orderId;
                    $data->restaurantId = $row->restaurantId;
                    $data->cost = $row->cost;
                    $data->freight = $row->freight;
                    $data->picture = $row->picture;

                        array_push($data->OrderDetail, $oderData);
                        array_push($dataToClient, $data);
                    }
                }
                

            }
        }
    }
    $dataToClient = json_encode($dataToClient);
    echo $dataToClient;
} else {
    echo "No Get Request";
}


/* --------------------------------------------------------------- */
// [
//   {
//     proposalIdl,
//     proposalOrderDetail:[
//       {
//         orderid
//         emailPartyB
//         count
//       }
//       {
//         orderid
//         emailPartyB
//         count
//       }
//     ]
//     shop: 
//     meal
//   },
//   {
//     proposalId,
//     proposalOrderDetail:[
//       {
//         orderid
//         emailPartyB
//         count
//       }
//       {
//         orderid
//         emailPartyB
//         count
//       }
//     ]
//     shop: 
//     meal
//   }

// ]