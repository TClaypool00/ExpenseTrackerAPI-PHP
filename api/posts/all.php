<?php
// Get All headers
include '../../partialFiles/get_all_headers.php';
// Creating a new instance of Posts and DB obj
include "../../partialFiles/objects_partial_files/new_post.php";

$all_posts = $post->getAll();
$num = $all_posts->rowCount();

if ($num > 0) {
    $posts_arr = array();

    while ($row = $all_posts->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            "postId" => $postId,
            "title" => $title,
            "postBody" => $postBody,
            "date" => $date,
            "userId" => $userId
        );

        array_push($posts_arr, $post_item);
    }

    http_response_code(200);
    echo json_encode($posts_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No Posts found."));
}