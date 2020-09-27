<?php
// Headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of DB and Loan
include "../../partialFiles/objects_partial_files/new_loan.php";

$all_loans = $loan->getAll();
$num = $all_loans->rowCount();

if($num > 0) {
    $loan_arr["records"] = array();

    while ($row = $all_loans->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "loanId" => $loanId,
            "loanName" => $loanName,
            "dueDate" => $dueDate,
            "monthlyAmountDue" => $monthlyAmountDue,
            "deposit" => $deposit,
            "totalAmountDue" => $totalAmountDue,
            "budgetId" => $budgetId,
            "storeId" => $storeId
        );

        array_push($loan_arr["records"], $item);

        http_response_code(200);
        echo json_encode($loan_arr);
    }

} else {
    http_response_code(404);
    echo json_encode(array("message" => "No loans found."));
    
}