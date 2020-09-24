<?php
// Delete headers
include "../../partialFiles/delete_headers.php";
// Creating a new instance of misc and DB obj
include "../../partialFiles/objects_partial_files/new_misc.php";

$misc->miscId = isset($_GET["miscId"]) ? $_GET["miscId"] : die();

if($msic->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Miscallanous was deleted."));
} else if($misc->price == null) {
    http_response_code(404);
    echo json_encode(array("message" => "Miscallanous was not found."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "API or Database was not avaiable."));
}