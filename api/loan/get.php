<?php
// Get by Id headers
include "../../partialFiles/get_by_id_headers.php";
// Creating a new instance of a loan and DB
include "../../partialFiles/objects_partial_files/new_loan.php";

// Get Id
$loan->loanId = isset($_GET["loanId"]) ? $_GET["loanId"] : die();

if($loan->loanName != null) {
    $loan_arr = array(
        "loanName" => $loan->loanName,
        "dueDate" => $loan->dueDate,
        "monthlyAmountDue" => $loan->monthlyAmountDue,
        "deposit" => $loan->deposit,
        "totalAmountDue" => $loan->totalAmountDue,
        "budgetId" => $loan->budgetId,
        "storeId" => $loan->storeId
    );

    http_response_code(200);
    echo json_encode($loan_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Loan with an Id of " . $loan->loanId . " does not exist."));
}