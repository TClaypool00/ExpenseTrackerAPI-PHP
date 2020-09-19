<?php
include_once "../../models/subs.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$sub = new Subscriptions($db);