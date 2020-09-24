<?php
include_once "../../models/misc.php";
include_once "../../config/Database.php";

$database = new Database();
$db = $database->connect();

$misc = new Misc($db);