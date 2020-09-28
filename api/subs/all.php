<?php
// Headers
include "../../partialFiles/get_all_headers.php";

// New instance of subscriptions
include "../../partialFiles/objects_partial_files/new_sub.php";

// Get all subs
$all_subs = $sub->getAll();
$num = $all_subs->rowCount();

if ($num > 0) {
    $sub_array = array();

    while ($row = $all_subs->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "subId" => $subId,
            "dueDate" => $dueDate,
            "amountDue" => $amountDate,
            "budgetId" => $budgetId,
            "storeId" => $storeId,
            "subName" => $subName
        );

        array_push($sub_array, $item);

        // Returns 200 if there are subscriptions
        http_response_code(200);

        echo json_encode($sub_array);
    }
} else {
    // No subscriptions
    http_response_code(404);

    echo json_encode(array("message" => "No subscriptions found."));
}
