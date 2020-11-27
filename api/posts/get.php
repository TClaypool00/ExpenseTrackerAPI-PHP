<?php
// Get By Id headers
include "../../partialFiles/get_by_id_headers.php";
// Creating a new instance of the Posts and Db obj
include "../../partialFiles/objects_partial_files/new_post.php";

$post->postId = isset($_GET["postId"]) ? $_GET["postId"] : die();

$post->getbyId();

if ($post->title != null) {
    $post_arr = array(
        "postId" => $post->postId,
        "title" => $post->title,
        "postBody" => $post->postBody,
        "date" => $post->date,
        "userId" => $post->userId
    );

    http_response_code(200);
    echo json_encode($post_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Post with an id of " . $_GET["postId"]. " can not be found."));
}