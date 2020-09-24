<?php
// Update headers
include "../../partialFiles/update_headers.php";
// Creating a new instance of loan and DB
include "../../partialFiles/objects_partial_files/new_loan.php";

$data = json_decode(file_get_contents("php://input"));

$loan->loanId = isset($_GET["loanId"]) ? $_GET["loanId"] : die();
$loan->loanName = $data->loanName;
$loan->dueDate = $data->dueDate;
$loan->monthlyAmountDue = $data->monthlyAmountDue;
$loan->deposit = $data->deposit;
$loan->totalAmountDue = $data->totalAmountDue;
$loan->userId = $data->userId;
$loan->storeId = $data->storeId;

if($loan->create()) {
    http_response_code(200);
    echo json_encode(array("message" => "Loan was updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update loan."));
}