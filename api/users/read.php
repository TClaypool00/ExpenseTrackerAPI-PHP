<?php
// require headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../../config/database.php';
include_once "../objects/users.php";

// create an instance of the database and object files
$database = new Database();
$db = $database->getConnection();

$users = new Users($db);

// query Users

$allUsers = $users->read();
$num = $allUsers->rowCount();

if ($num > 0) {
    $user_arr = array();
    $user_arr["records"] = array();

    while ($row = $allUsers->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            "UserId" => $UserId,
            "FirstName" => $FirstName,
            "LastName" => $LastName,
            "EmailAddress" => $EmailAddress,
            "Password" => $Password,
            "IsAdmin" => $IsAdmin,
            "Address" => $Address,
            "City" => $City,
            "State" => $State,
            "Zip" => $Zip
        );

        array_push($user_arr["records"], $user_item);
    }

    http_response_code(200);

    // show user data in JSON format

    echo json_encode($user_arr);
} else {
    // No users found
    http_response_code(404);

    echo json_encode(
        array("messsage" => "No Users found.")
    );
}
