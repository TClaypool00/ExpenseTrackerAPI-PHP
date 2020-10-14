<?php
// Show error reporting
error_reporting(E_ALL);
// Set default timezone
date_default_timezone_set("UTC");

// Set variablees used for JWT
$key = "example_key";
$issued_at = time();
$exiration_time = $issued_at + (60 * 60); // One hour
$issuer = "http://localhost/ExpenseTrackerAPI-PHP/";