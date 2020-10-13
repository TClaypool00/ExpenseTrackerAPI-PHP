<?php
// Get by Id Headers
include "../../partialFiles/get_by_id_headers.php";
// Creating a new instance of misc and DB obj
include "../../partialFiles/objects_partial_files/new_misc.php";

$misc->miscId = isset($_GET["miscId"]) ? $_GET["miscId"] : die();
$misc->getbyId();

if($misc->price != null) {
    $misc_arr = array(
        "miscId" => $misc->miscId,
        "price" => $misc->price,
        "date" => $misc->date,
        "storeId" => $misc->storeId,
        "budgetId" => $misc->budgetId
    );

    http_response_code(200);
    echo json_encode($misc_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Miscellaneous not found"));
}