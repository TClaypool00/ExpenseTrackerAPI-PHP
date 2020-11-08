<?php
// Create headers
include "../../partialFiles/create_headers.php";

// get database connection
include "../../partialFiles/objects_partial_files/new_user.php";

$data = json_decode(file_get_contents("php://input"));

$user->firstName = $data->firstName;
$user->lastName = $data->lastName;
$user->email = $data->email;
$user->password = $data->password;
$user->isAdmin = $data->isAdmin;
$user->phoneNum = $data->phoneNum;
$user->salary = $data->salary;

// Create User
if ($user->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "User was created."));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user."));
}