<?php
include_once "../../models/users.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$user = new Users($db);