<?php
// Create Headers
include "../../partialFiles/create_headers.php";
// Creating a new instance of budget and DB obj
include "../../partialFiles/objects_partial_files/new_budget.php";

$data = json_decode(file_get_contents("php://input"));

$budget->totalBills = $data->totalBills;
$budget->moneyLeft = $data->moneyLeft;
$budget->savingsMoney = $data->savingsMoney;
$budget->userId = $data->userId;

if($budget->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Budget was created"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create budget."));
}