<?php
include "../../partialFiles/update_headers.php";

include "../../partialFiles/newBill.php";

$data = json_decode(file_get_contents("php://input"));

$bill->billId = $data->billId;

if($bill->delete()) {
    http_response_code(200);

    echo json_encode(array("message" => "Bill was deleted"));
} else {
    http_response_code(503);

    echo json_encode(array("message" => "Unable to delete bill"));
}