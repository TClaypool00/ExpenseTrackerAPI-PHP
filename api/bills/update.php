<?php

include "../../partialFiles/update_headers.php";

include "../../partialFiles/objects_partial_files/newBill.php";

$data = json_decode(file_get_contents("php://input"));

$bill->billId = isset($_GET["billId"]) ? $_GET["billId"] : die();
$bill->billName = $data->billName;
$bill->billPrice = $data->billPrice;
$bill->billDate = $data->billDate;
$bill->isLate = $data->isLate;
$bill->endDate = $data->endDate;
$bill->userId = $data->userId;
$bill->storeId = $data->storeId;

if($bill->update()) {
    http_response_code(200);

    echo json_encode(array("message" => "Bill was updated"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to update bill"));
}