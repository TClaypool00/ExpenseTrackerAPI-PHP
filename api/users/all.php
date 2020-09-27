<?php
// Get all headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of users and DB obj
include "../../partialFiles/objects_partial_files/new_user.php";

$allUsers = $user->read();
$num = $allUsers->rowCount();

if ($num > 0) {
    $user_arr["records"] = array();

    while ($row = $allUsers->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            "userId" => $userId,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "password" => $password,
            "isAdmin" => $isAdmin,
            "phoneNum" => $phoneNum,
            "salary" => $salary
        );

        array_push($user_arr["records"], $user_item);
    }

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No users found."));
}
