<?php
// Headers
include "../../partialFiles/get_by_id_headers.php";
// creating a new store/credit union
include "../../partialFiles/objects_partial_files/new_storeunion.php";

// Get Id
$store->storeId = isset($_GET["storeId"]) ? $_GET["storeId"] : die();
$store->getById();

if($store->storeName != null) {
    $store_array = array(
        "storeId" => $store->storeId,
        "storeName" => $store->storeName,
        "address" => $store->address,
        "city" => $store->city,
        "state" => $store->state,
        "zip" => $store->zip,
        "phoneNum" => $store->phoneNum,
        "email" => $store->email,
        "webiste" => $store->website,
        "isCreditUnion" => $store->isCreditUnion,
        "isCompleted" => $store->isCompleted
    );

    http_response_code(200);
    echo json_encode($store_array);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Store or Credit union with an id of " . $store->storeId . " does not exist."));
}