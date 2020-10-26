<?php
// Get all headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of users and DB obj
include "../../partialFiles/objects_partial_files/new_user.php";

$allUsers = $user->read();
$num = $allUsers->rowCount();

if ($num > 0) {
    $user_arr = array();

    while ($row = $allUsers->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            "userId" => $userId,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "password" => $password,
            "is_superuser" => $is_superuser,
            "phoneNum" => $phoneNum,
            "salary" => $salary,
            "date_joined" => $date_joined,
            "is_active" => $is_active,
            "is_staff" => $is_staff,
            "last_login" => $last_login

        );

        array_push($user_arr, $user_item);
    }

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No users found."));
}
