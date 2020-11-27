<?php
include_once "../../DataAccess/models/reply.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$reply = new Reply($db);