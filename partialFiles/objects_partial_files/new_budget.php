<?php
include_once "../../models/budgets.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$budget = new Budgets($db);