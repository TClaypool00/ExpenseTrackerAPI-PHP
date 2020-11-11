<?php
// Create headers
include "../../partialFiles/create_headers.php";
// Creating a new instance of misc and DB obj
include "../../partialFiles/objects_partial_files/new_misc.php";

$data = json_decode(file_get_contents("php://input"));

$misc->price = $data->price;
$misc->storeId = $data->storeId;
$misc->date = date("Y-m-d");
$misc->userId = $data->userId;
$misc->memo = $data->memo;
$misc->miscName = $data->miscName;

if($misc->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "miscellaneous was created!"));
} else if($misc->price == null || $misc->date == null || $misc->userId == null || $misc->storeId == null) {
    http_response_code(400);
    echo json_encode(array("message" => "Something was empty. Try again."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Serive is unavaliable."));
}