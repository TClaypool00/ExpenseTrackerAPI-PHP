<?php
include_once "../../models/storeunion.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$store = new StoreUnion($db);