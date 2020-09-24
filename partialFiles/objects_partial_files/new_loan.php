<?php
include_once "../../models/loan.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$loan = new Loan($db);