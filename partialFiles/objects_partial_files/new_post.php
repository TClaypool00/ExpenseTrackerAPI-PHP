<?php
include_once "../../DataAccess/models/posts.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$post = new Posts($db);