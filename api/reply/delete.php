<?php
// Delete headers
include "../../partialFiles/delete_headers.php";
// Creating a new instance of Reply and DB obj
include "../../partialFiles/objects_partial_files/new_reply.php";

$reply->replyiId = isset($_GET["replyId"]) ? $_GET["replyId"] : die();

if ($reply->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Reply was deleted."));
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Unable to delete reply."));
}