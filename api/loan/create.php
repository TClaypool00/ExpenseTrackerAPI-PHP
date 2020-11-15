<?php
// Create Headers
include "../../partialFiles/create_headers.php";
// Creating a new instance of loan and DB object
include "../../partialFiles/objects_partial_files/new_loan.php";

$data = json_decode(file_get_contents("php://input"));

$loan->loanName = $data->loanName;
$loan->dueDate = $data->dueDate;
$loan->monthlyAmountDue = $data->monthlyAmountDue;
$loan->deposit = $data->deposit;
$loan->totalAmountDue = $data->totalAmountDue;
$loan->amountRemaining = $loan->totalAmountDue - $loan->deposit;
$loan->isLate = false;
$loan->isPaid = false;
$loan->storeId = $data->storeId;
$loan->userId = $data->userId;


if($loan->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Loan was created."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create loan."));
}