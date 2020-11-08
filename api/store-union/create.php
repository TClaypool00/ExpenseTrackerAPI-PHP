<?php
// Headers
include "../../partialFiles/create_headers.php";
// Creating a new store/creditunion
include "../../partialFiles/objects_partial_files/new_storeunion.php";

$data = json_decode(file_get_contents("php://input"));

$store->storeName = $data->storeName;
$store->address = $data->address;
$store->city = $data->city;
$store->state = $data->state;
$store->zip = $data->zip;
$store->phoneNum = $data->phoneNum;
$store->email = $data->email;
$store->website = $data->website;
$store->isCreditUnion = $data->isCreditUnion;

if($store->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Store or Credit Union was created!"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Store or Credit Union."));
}