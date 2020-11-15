<?php
// Get all headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of the bill and DB obj
include "../../partialFiles/objects_partial_files/newBill.php";

$all_bills = $bill->getAll();
$num = $all_bills->rowCount();

if ($num > 0) {
    $bill_arr = array();

    while ($row = $all_bills->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $bill_item = array(
            "billId" => $billId,
            "billName" => $billName,
            "billDate" => $billDate,
            "billPrice" => $billPrice,
            "isLate" => $isLate,
            "storeId" => $storeId,
            "storeName" => $storeName,
            "storeWebsite" => $website,
            "userId" => $userId
        );

        array_push($bill_arr, $bill_item);
    }

    http_response_code(200);
    echo json_encode($bill_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No bills found."));
}