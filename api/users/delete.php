<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-Width");

// get database connection
include_once "../../config/Database.php";
include_once "../../models/users.php";

$database = new Database();
$db = $database->connect();

$user = new Users($db);

$data = json_decode(file_get_contents("php://input"));

$user->userId = $data->userId;

// Create User
if ($user->delete()) {

    // set response code - 201 created
    http_response_code(201);

    // tell the user
    echo json_encode(array("message" => "User was deleted."));
} else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete user."));
}