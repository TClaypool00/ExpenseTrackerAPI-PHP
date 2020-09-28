<?php
// Headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of a store/union and DB
include "../../partialFiles/objects_partial_files/new_storeunion.php";

// Get all store/credit union
$all_stores = $store->getAll();
$num = $all_stores->rowCount();

if ($num > 0) {
    $store_arr = array();

    while ($row = $all_stores->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "storeId" => $storeId,
            "storeName" => $storeName,
            "address" => $address,
            "city" => $city,
            "state" => $state,
            "zip" => $zip,
            "phoneNum" => $phoneNum,
            "email" => $email,
            "website" => $website
        );

        array_push($store_arr, $item);
    }

    http_response_code(200);
    echo json_encode($store_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No stores or credit unions found."));
}
