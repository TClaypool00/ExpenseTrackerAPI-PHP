<?php
// Headers
include "../../partialFiles/get_by_id_headers.php";

// creating a new subscription
include "../../partialFiles/objects_partial_files/new_sub.php";

// Get Id
$sub->subId = isset($_GET["subId"]) ? $_GET["subId"] : die();
$sub->getById();

if($sub->companyName != null) {
    $sub_array = array(
        "dueDate" => $sub->dueDate,
        "amountDue" => $sub->amountDue,
        "userId" => $sub->userId,
        "storeId" => $sub->storeId
    );

    http_response_code(200);

    echo json_encode($sub_array);
} else {
    http_response_code(404);

    echo json_encode(array("message" => "Subscription with an id of " . $sub->subId . " does not exist"));
}