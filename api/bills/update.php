<?php

include "../../partialFiles/update_headers.php";

include "../../partialFiles/newBill.php";

$data = json_decode(file_get_contents("php://input"));

$bill->billId = $data->billId;
$bill->billName = $data->billName;
$bill->billPrice = $data->billPrice;
$bill->billDate = $data->billDate;
$bill->isLate = $data->isLate;
$bill->userId = $data->userId;

if($bill->update()) {
    http_response_code(200);

    echo json_encode(array("message" => "Bill was updated"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to update bill"));
}