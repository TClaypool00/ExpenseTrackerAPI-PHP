<?php
// headers
include "../../partialFiles/create_headers.php";

// Creating a new instance of a bill
include "../../partialFiles/objects_partial_files/newBill.php";

$data = json_decode(file_get_contents("php://input"));

$bill->billName = $data->billName;
$bill->billPrice = $data->billPrice;
$bill->billDate = $data->billDate;
$bill->isLate = $data->isLate;
$bill->budgetId = $data->budgetId;
$bill->storeId = $data->storeId;

if($bill->create()){
    http_response_code(201);

    echo json_encode(array("message" => "Bill was created!"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to create bill"));
}