<?php
// Headers
include "../../partialFiles/update_headers.php";
// Create a new instance of store/credit union and db
include "../../partialFiles/objects_partial_files/new_storeunion.php";

$data = json_decode(file_get_contents("php://input"));
$store->storeId = isset($_GET["storeId"]) ? $_GET["storeId"] : die();
$store->storeName = $data->storeName;
$store->address = $data->address;
$store->city = $data->city;
$store->state = $data->state;
$store->zip = $data->zip;
$store->phoneNum = $data->phoneNum;
$store->email = $data->email;
$store->website = $data->website;
$store->isCreditUnion = $data->isCreditUnion;
$store->isCompleted = $data->isCompleted;

if($store->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Store or Credit Union was updated!"));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update Store or Credit Union."));
}