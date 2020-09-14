<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../../config/database.php';
include_once "../objects/users.php";

// create an instance of the database and object files
$database = new Database();
$db = $database->connect();

$users = new Users($db);

// Get Id
$users->UserId = isset($_GET["userId"]) ? $_GET["userId"] : die();

$users->read_single();

$user_array = array(
    "userId" => $users->userId,
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

print_r(json_encode($user_array));