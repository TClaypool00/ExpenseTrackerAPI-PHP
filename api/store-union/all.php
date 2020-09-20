<?php
// Headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of db and store/union
include "../../partialFiles/objects_partial_files/new_storeunion.php";

// Get all store/credit union
$all_stores = $store->getall();
$num = $all_stores->rowCount();

// If there are more than 1 store/credit union
if($num > 0) {
    $store_array["records"] = array();

    while($row = $all_stores->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "storeName" => $storName,
            "address" => $address,
            "city" => $city,
            "state" => $state,
            "zip" => $zip
        );

        array_push($store_array["records"], $item);

        http_response_code(200);

        echo json_encode($store_array);
    }
} else {
    // If there are no stores/credit unions
    http_response_code(404);

    echo json_encode(array("message" => "No stores or credit unions found."));
}
