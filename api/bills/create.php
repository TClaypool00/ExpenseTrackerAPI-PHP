<?php
// headers
include "../../partialFiles/create_headers.php";

// Creating a new instance of a bill
include "../../partialFiles/newBill.php";

$data = json_decode(file_get_contents("php://input"));

$bill->billName = $data->billName;
$bill->billPrice = $data->billPrice;
$bill->billDate = $data->billDate;
$bill->isLate = $data->isLate;
$bill->userId = $data->userId;

if($bill->create()){
    http_response_code(201);

    echo json_encode(array("message" => "Bill was created!"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to create bill"));
}