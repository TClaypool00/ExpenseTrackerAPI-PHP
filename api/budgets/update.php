<?php
// Update Headers
include "../../partialFiles/update_headers.php.php";
// Creating a new instance of budget and DB obj
include "../../partialFiles/objects_partial_files/new_budget.php";

$data = json_decode(file_get_contents("php://input"));

$budget->budgetId = isset($_GET["budgetId"]) ? $_GET["budgetId"] : die();
$budget->totalBills = $data->totalBills;
$budget->moneyLeft = $data->moneyLeft;
$budget->userId = $data->userId;

if($budget->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Budget was updated."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update budget."));
}