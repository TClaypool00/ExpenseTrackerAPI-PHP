<?php
include "../../partialFiles/update_headers.php";

include "../../partialFiles/objects_partial_files/newBill.php";

$bill->billId = isset($_GET["billId"]) ? $_GET["billId"] : die();

if($bill->delete()) {
    http_response_code(200);

    echo json_encode(array("message" => "Bill was deleted"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to delete bill"));
}