<?php
// Headers
header("Access-Control-Allow-Origin: http://localhost/ExpenseTrackerAPI-PHP/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// Creating a new instance of the user and database obj
include "../../partialFiles/objects_partial_files/new_user.php";

$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
$user->password = $data->email;
// Checks if email entered in exists in the database - returns true if email does exist
// And false if the email does not exist
$email_exist = $user->emailExist();

// generate json web token
include_once "../../config/core.php";
include_once "../../libs/BeforeValidException.php";
include_once "../../libs/ExpiredException.php";
include_once "../../libs/SignatureInvalidException.php";
include_once "../../libs/JWT.php";
use \Firebase\JWT\JWT;

// Checks if email exists and if password is correct
if($email_exist && $data->password == $user->password) {
    $token = array(
        "issuedAt" => $issued_at,
        "expiration_time" => $exiration_time,
        "issuer" => $issuer,
        "data" => array(
            "userId" => $user->userId,
            "firstName" => $user->firstName,
            "lastName" => $user->lastName,
            "email" => $user->email
        )
    );

    // Response code
    http_response_code(200);
    // Geneate JWT
    $jwt = JWT::encode($token, $key);

    echo json_encode(
        array(
            "message" => "Login successful!",
            "jwt" => $jwt
        )
    );
    // Login failed
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Login failed."));
}