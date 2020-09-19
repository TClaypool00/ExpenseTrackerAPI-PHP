<?php
// Headers
include "../../partialFiles/get_by_id_headers.php";

// Creating a new intance of a bill
include "../../partialFiles/newBill.php";

$bill->billId = isset($_GET["billId"]) ? $_GET["billId"] : die();

$bill->getById();

if($bill->billName != null) {
    $bill_array = array (
        "billName" => $bill->billName,
        "billDate" => $bill->billDate,
        "billPrice" => $bill->billPrice,
        "isLate" => $bill->isLate,
        "userId" => $bill->userId
    );

    http_response_code(200);

    echo json_encode($bill_array);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Bill with an id of " . $bill->billId . " does not exist."));
}