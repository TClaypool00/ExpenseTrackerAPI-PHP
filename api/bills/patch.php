<?php
// Patch Headers
include "../../partialFiles/patch_headers.php";
// Creating a new instance of the Bill and DB obj
include "../../partialFiles/objects_partial_files/newBill.php";

$column = isset($_GET["value"]) ? $_GET["value"] : die();
$value = isset($_GET["value"]) ? $_GET["value"] : die();
$bill->billId = isset($_GET["billId"]) ? $_GET["billId"] : die();

if($bill->patch($column, $value)) {
    http_response_code(201);
    echo json_encode(array("message" => "Bill was updated."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Bill could not be updated."));
}