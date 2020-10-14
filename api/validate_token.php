<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get files required to decode jwt
include_once "../config/core.php";
include_once "../libs/BeforeValidException.php";
include_once "../libs/ExpiredException.php";
include_once "../libs/SignatureInvalidException.php";
include_once "../libs/JWT.php";
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

// Get JWT
$jwt = isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt) {
    // If decode suceed, show user details
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array("HS256"));
        http_response_code(200);
        // Show user details
        echo json_encode(array(
            "message" => "Access granted",
            "data" => $decoded->data
        ));
    } catch(Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied",
            "error" => $e->getMessage()
        ));
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}