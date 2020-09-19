<?php
// Headers
include "../../partialFiles/get_all_headers.php";

// Create a new instance of a bill
include "../../partialFiles/objects_partial_files/newBill.php";

// Get all bills
$allBills = $bill->getall();
$num = $allBills->rowCount();

if($num > 0) {
    $bill_arr = array();
    $bill_arr["records"] = array();

    while ($row = $allBills->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $bill_item = array(
            "billId" => $billId,
            "billName" => $billName,
            "billDate" => $billDate,
            "billPrice" => $billPrice,
            "isLate" => $isLate,
            "userId" => $userId
        );

        array_push($bill_arr["records"], $bill_item);
    }

    http_response_code(200);

    // Shows bill data in JSON format

    echo json_encode($bill_arr);
} else {
    // No bills found
    http_response_code(404);

    echo json_encode(
        array("message" => "No bills found")
    );
}