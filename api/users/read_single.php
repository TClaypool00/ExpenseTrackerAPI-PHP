<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Include database and object files
include_once "../../config/Database.php";
include_once "../../models/users.php";

// create an instance of the database and object files
$database = new Database();
$db = $database->connect();

$users = new Users($db);

// Get Id
$users->userId = isset($_GET['userId']) ? $_GET['userId'] : die();

$users->read_single();

if($users->firstName != null){

    $user_array = array(
        "firstName" => $users->firstName,
        "lastName" => $users->lastName,
        "email" => $users->email,
        "password" => $users->password,
        "isAdmin" => $users->isAdmin,
        "address" => $users->address,
        "city" => $users->city,
        "state" => $users->state,
        "zip" => $users->zip
    );

    http_response_code(200);

    echo(json_encode($user_array));
} else {
    http_response_code(404);

    echo json_encode(array("message" => "User with an id of " . $users->userId . " does not exist"));
}