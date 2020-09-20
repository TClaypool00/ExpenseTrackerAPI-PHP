<?php
// Delete Headers
include "../../partialFiles/delete_headers.php";
// Creating a new instance of store or credit union and DB
include "../../partialFiles/objects_partial_files/new_storeunion.php";

$store->storeId = isset($_GET["storeId"]) ? $_GET["storeId"] : die();

if($store->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Store or Credit Union was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete Store or Credit Union."));
}