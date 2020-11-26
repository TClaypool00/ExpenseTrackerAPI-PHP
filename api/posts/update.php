<?php
// Update headers
include "../../partialFiles/update_headers.php";
// Creating a new instance of Posts and DB obj
include "../../partialFiles/objects_partial_files/new_post.php";

$data = json_decode(file_get_contents("php://input"));

$post->postId = isset($_GET["postId"]) ? $_GET["postId"] : die();
$post->title = $data->title;
$post->postBody = $data->postBody;
$post->date = date("Y-m-d");
$post->userId = $data->userId;

if ($post->update()) {
    http_response_code(201);
    echo json_encode(array("message" => "Post was updated!"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Post was not updated."));
}