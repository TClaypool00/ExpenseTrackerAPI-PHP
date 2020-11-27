<?php
// Update headers
include "../../partialFiles/update_headers.php";
// Creating a new instance of Reply and DB obj
include "../../partialFiles/objects_partial_files/new_reply.php";

$data = json_decode(file_get_contents("php://input"));

$reply->replyiId = isset($_GET["replyId"]) ? $_GET["replyId"] : die();
$reply->replyBody = $data->replyBody;
$reply->date = date("Y-m-d");
$reply->postId = $data->postId;
$reply->userId = $data->userId;

if ($reply->create()) {
    http_response_code(204);
    echo json_encode(array("message" => "Reply was Updated!"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update reply."));
}