<?php
// Get by Id headers
include "../../partialFiles/get_by_id_headers.php";
// Creating a new instance of users and DB obj
include "../../partialFiles/objects_partial_files/new_user.php";

// Get Id
$user->userId = isset($_GET['userId']) ? $_GET['userId'] : die();

$user->read_single();

if($user->firstName != null){

    $user_array = array(
        "firstName" => $user->firstName,
        "lastName" => $user->lastName,
        "email" => $user->email,
        "password" => $user->password,
        "isAdmin" => $user->isAdmin,
        "phoneNum" => $user->phoneNum,
        "salary" => $user->salary
    );

    http_response_code(200);

    echo(json_encode($user_array));
} else {
    http_response_code(404);

    echo json_encode(array("message" => "User with an id of " . $user->userId . " does not exist"));
}