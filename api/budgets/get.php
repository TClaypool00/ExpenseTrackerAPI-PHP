<?php
// Get by Id Headers
include "../../partialFiles/get_by_id_headers.php";
// Creating a new instance of budget and DB obj
include "../../partialFiles/objects_partial_files/new_budget.php";

$budget->budgetId = isset($_GET["budgetId"]) ? $_GET["budgetId"] : die();
$budget->getById();

if($budget->totalBills != null) {
    $budget_arr = array(
        "budgetId" => $budget->budgetId,
        "totalBills" => $budget->totalBills,
        "moneyLeft" => $budget->moneyLeft,
        "savingsMoney" => $budget->savingsMoney,
        "userId" => $budget->userId
    );

    http_response_code(200);
    echo json_encode($budget_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Budget does not exist."));
}