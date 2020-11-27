<?php
// Get By Id headers
include "../../partialFiles/get_by_id_headers.php";
// Creating a new instance of Reply and DB obj
include "../../partialFiles/objects_partial_files/new_reply.php";

$reply->replyiId = isset($_GET["replyId"]) ? $_GET["replyId"] : die();

$reply->getById();

if ($reply->replyBody != null) {
    $reply_arr = array(
        "replyId" => $reply->replyiId,
        "replyBody" => $reply->replyBody,
        "date" => $reply->date,
        "postId" => $reply->postId,
        "userId" => $reply->userId
    );

    http_response_code(200);
    echo json_encode($reply_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Reply with an id of " . $reply->replyiId . " was not found."));
}