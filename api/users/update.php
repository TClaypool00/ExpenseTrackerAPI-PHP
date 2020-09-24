<?php
// Update headers
include "../../partialFiles/update_headers.php";
// Creating a new instance of users and DB obj
include "../../partialFiles/objects_partial_files/new_user.php";

$data = json_decode(file_get_contents("php://input"));

$user->userId = isset($_GET["userId"]) ? $_GET["userId"] : die();
$user->firstName = $data->firstName;
$user->lastName = $data->lastName;
$user->email = $data->email;
$user->password = $data->password;
$user->phoneNum = $data->phoneNum;
$user->salary = $data->salary;

if ($user->update()) {
    http_response_code(201);
    echo json_encode(array("message" => "User was updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update user."));
}