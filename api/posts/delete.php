<?php
// Delete headers
include "../../partialFiles/delete_headers.php";
// Creating a new instance of Posts and Db obj
include "../../partialFiles/objects_partial_files/new_post.php";

$post->postId = isset($_GET["postId"]) ? $_GET["postId"] : die();

if ($post->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Post was deleted"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to post"));
}