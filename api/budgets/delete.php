<?php
// Delete headers
include "../../partialFiles/delete_headers.php";
// Creating a new instance of budget and DB obj
include "../../partialFiles/objects_partial_files/new_budget.php";

$budget->budgetId = isset($_GET["budgetId"]) ? $_GET["budgetId"] : die();

if($budget->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Budget was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete budget."));
}