<?php
// Create headers
include "../../partialFiles/create_headers.php";
// Creating a new instance of the Posts and DB ob
include "../../partialFiles/objects_partial_files/new_post.php";

$data = json_decode(file_get_contents("php://input"));

$post->title = $data->title;
$post->postBody = $data->postBody;
$post->date = date("Y-m-d");
$post->userId = $data->userId;

if ($post->create()) {
    http_response_code(201);
    echo json_encode(array("message" => "Post was created!"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create post."));
}