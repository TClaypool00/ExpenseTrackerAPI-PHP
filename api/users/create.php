<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once "../../config/database.php";
include_once "../objects/users.php";

$database = new Database();
$db = $database->getConnection();

$user = new Users($db);

$data = json_decode(file_get_contents("php://input"));

// First make sure data is empty
if (
    !empty($data->FirstName) &&
    !empty($data->LastName) &&
    !empty($data->EmailAddress) &&
    !empty($data->Password) &&
    !empty($data->IsAdmin) &&
    !empty($data->Address) &&
    !empty($data->City) &&
    !empty($data->State) &&
    !empty($data->Zip)
) {
    $user->FirstName = $data->FirstName;
    $user->LastName = $data->LastName;
    $user->EmailAddress = $data->EmailAddress;
    $user->Password = $data->Password;
    $user->IsAdmin = $dta->IsAdmin;
    $user->Address = $data->Address;
    $user->City = $data->City;
    $user->State = $data->State;
    $user->Zip = $data->Zip;

    // Create User
    if ($user->create()) {

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }

    // if unable to create the product, tell the user
    else {

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}

// tell the user data is incomplete
else {

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
