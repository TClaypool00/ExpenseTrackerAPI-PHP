<?php
// Headers
include "../../partialFiles/delete_headers.php";

// Creating a new instance of a subscription and DB
include "../../partialFiles/objects_partial_files/new_sub.php";

$sub->subId = isset($_GET["subId"]) ? $_GET["subId"] : die();

if($sub->delete()) {
    http_response_code(200);

    echo json_encode(array("message" => "Subscription was deleted"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to delete subscription"));
}