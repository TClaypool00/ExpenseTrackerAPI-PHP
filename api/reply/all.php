<?php
// Get All headers
include "../../partialFiles/get_all_headers.php";
// Creating a new instance of Reply and DB obj
include "../../partialFiles/objects_partial_files/new_reply.php";

$all_replies = $reply->getAll();
$num = $all_replies->rowCount();

if ($num > 0) {
    $reply_arr = array();

    while ($row = $all_replies->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $reply_item = array(
            "replyId" => $replyId,
            "replyBody" => $replyBody,
            "date" => $date,
            "postId" => $postId,
            "userId" => $userId,
            "userFirstName" => $firstName,
            "userLastName" => $lastName
        );

        array_push($reply_arr, $reply_item);
    }

    http_response_code(200);
    echo json_encode($reply_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No replies found."));
}