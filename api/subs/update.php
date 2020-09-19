<?php
// Headers
include "../../partialFiles/update_headers.php";
// Create a new instance of sub and Db
include "../../partialFiles/objects_partial_files/new_sub.php";

$data = json_decode(file_get_contents("php://input"));

$sub->subId = isset($_GET["subId"]) ? $_GET["subId"] : die();
$sub->companyName = $data->companyName;
$sub->dueDate = $data->dueDate;
$sub->amountDue = $data->amountDue;
$sub->userId = $data->userId;

if($sub->update()) {
    http_response_code(200);

    echo json_encode(array("message" => "Subscription was updated"));
} else {
    http_response_code(503);
    
    echo json_encode(array("message" => "Unable to update subscription"));
}