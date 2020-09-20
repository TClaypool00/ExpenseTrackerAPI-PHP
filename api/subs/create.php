<?php
// Headers
include "../../partialFiles/create_headers.php";

// Create a new instance of sub and DB
include "../../partialFiles/objects_partial_files/new_sub.php";

$data = json_decode(file_get_contents("php://input"));

$sub->dueDate = $data->dueDate;
$sub->amountDue = $data->amountDue;
$sub->userId = $data->userId;
$sub->storeId = $data->storeId;

if($sub->create()) {
    http_response_code(201);

    echo json_encode(array("message" => "Subscription was created!"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to create subcription"));
}