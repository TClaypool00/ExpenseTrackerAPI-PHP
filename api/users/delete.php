<?php
// Delete heades
include "../../partialFiles/delete_headers.php";
// Creating a new instance of users and DB obj
include "../../partialFiles/objects_partial_files/new_user.php";

$user->userId = isset($_GET["userId"]) ? $_GET["userId"] : die();

// Create User
if ($user->delete()) {
    http_response_code(201);
    echo json_encode(array("message" => "User was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete user."));
}