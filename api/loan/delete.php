<?php
// Delete headers
include "../../partialFiles/delete_headers.php";
// Creating a new instance of loan and DB object
include "../../partialFiles/objects_partial_files/new_loan.php";

$loan->loanId = isset($_GET["loanId"]) ? $_GET["loanId"] : die();

if($loan->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Loan was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete loan."));
}