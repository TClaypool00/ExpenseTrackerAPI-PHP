<?php
// Get all headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of budget and DB obj
include "../../partialFiles/objects_partial_files/new_budget.php";

$all_budgets = $budget->getAll();
$num = $all_budgets->rowCount();

if ($num > 0) {
    $budget_arr = array();

    while ($row = $all_budgets->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "budgetId" => $budgetId,
            "totalBills" => $totalBills,
            "moneyLeft" => $moneyLeft,
            "savingsMoney" => $savingsMoney,
            "userId" => $userId
        );

        array_push($budget_arr, $item);

        http_response_code(200);
        echo json_encode($budget_arr);
    }
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No Budgets found."));
}
