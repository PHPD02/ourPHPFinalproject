<?php
include "../serverHeader.php";
include "../sql.php";

$sql = ' SELECT sunsua_order.id,sunsua_order.proposalId,emailPartyA,emailPartyB,shop,meal, cost, sunsua_order.count,proposal.freight,picUrl
        FROM (proposal RIGHT JOIN sunsua_order ON sunsua_order.proposalId = proposal.id)
        WHERE emailPartyA = ? ';
if ($_GET) {
    $emailPartyA = $_GET['emailPartyA'];
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $emailPartyA);
    $stmt->execute();
    $result = $stmt->get_result();

    class OrderDetail
    {
        var $orderid;
        var $emailPartyB;
        var $count;
    }
    class ProposalDetail
    {
        var $proposalId;
        var $shop;
        var $meal;
        var $cost;
        var $freight;
        var $picUrl;
        var $proposalOrderDetail = [];
    };

    $dataToClient = array();
    $data = [];
    if ($result) {
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_object()) {
                // echo $row->proposalId . ":" . $row->id . "<br/>\n";

                if (count($dataToClient) == 0) {
                    // echo "第一次<br/>\n";
                    $oderData = new OrderDetail;
                    $oderData->orderid = $row->id;
                    $oderData->emailPartyB = $row->emailPartyB;
                    $oderData->count = $row->count;
                    $data = new ProposalDetail;
                    $data->proposalId = $row->proposalId;
                    $data->shop = $row->shop;
                    $data->meal = $row->meal;
                    $data->cost = $row->cost;
                    $data->picUrl = $row->picUrl;
                    $data->freight = $row->freight;
                    array_push($data->proposalOrderDetail, $oderData);
                    array_push($dataToClient, $data);
                } else {
                    $i = 0;
                    for ($i; $i < count($dataToClient); $i++) {
                        // echo "count(dataToClient) => " . count($dataToClient) . "<br/>\n";
                        // echo "proposalId : rowid => " . $dataToClient[$i]->proposalId . ":" . $row->id . "<br/>\n";
                        if ($dataToClient[$i]->proposalId == $row->proposalId) {
                            // echo "有這個proposal id了<br/>\n";
                            $oderData = new OrderDetail;
                            $oderData->orderid = $row->id;
                            $oderData->emailPartyB = $row->emailPartyB;
                            $oderData->count = $row->count;
                            array_push($dataToClient[$i]->proposalOrderDetail, $oderData);
                            break;
                        } else {
                            // echo "沒有這個proposal id，請建立新的<br/>\n";
                        }
                    }
                    if ($i == count($dataToClient)) {
                        $oderData = new OrderDetail;
                        $oderData->orderid = $row->id;
                        $oderData->emailPartyB = $row->emailPartyB;
                        $oderData->count = $row->count;
                        $data = new ProposalDetail;
                        $data->proposalId = $row->proposalId;
                        $data->shop = $row->shop;
                        $data->meal = $row->meal;
                        $data->cost = $row->cost;
                        $data->picUrl = $row->picUrl;
                        $data->freight = $row->freight;
                        array_push($data->proposalOrderDetail, $oderData);
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