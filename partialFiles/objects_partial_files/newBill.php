<?php
include_once "../../DataAccess/models/bills.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$bill = new Bills($db);