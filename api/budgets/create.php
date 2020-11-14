<?php
// Create Headers
include "../../partialFiles/create_headers.php";
// Creating a new instance of budget and DB obj
include "../../partialFiles/objects_partial_files/new_budget.php";

$data = json_decode(file_get_contents("php://input"));

// Get User Id from input
$budget->userId = $data->userId;

$total_bill = $budget->getTotalBillAmt();
$total_sub = $budget->getTotalSubAmt();
$total_loan = $budget->getTotalLoanAmt();
$salary = $budget->getSalary();

$total = $total_bill + $total_sub + $total_loan;

$budget->totalBills = $total;
$budget->moneyLeft = $salary - $total;
$budget->savingsMoney = null;

if($budget->budgetExist()) {
    http_response_code(400);
    echo json_encode(array("message" => "User already has a budget."));
} else {
    if($budget->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Budget was created."));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create budget."));
    }
}