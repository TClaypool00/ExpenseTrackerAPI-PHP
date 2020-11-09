<?php
// Get all Headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of msic and DB obj
include "../../partialFiles/objects_partial_files/new_misc.php";

$all_misc = $misc->getAll();
$num = $all_misc->rowCount();

if ($num > 0) {
    $misc_arr = array();

    while ($row = $all_misc->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $item = array(
            "miscId" => $miscId,
            "miscName" => $miscName,
            "price" => $price,
            "date" => $date,
            "memo" => $memo,
            "storeId" => $storeId,
            "storeName" => $storeName,
            "storeWebsite" => $website,
            "userId" => $userId,
        );

        array_push($misc_arr, $item);
    }
    http_response_code(200);

    echo json_encode($misc_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No Miscellaneous found."));
}
