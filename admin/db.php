<?php
// db.php

$host = "localhost";
$user = "root";      // XAMPP default
$pass = "";          // XAMPP default
$db = "directories";  // <-- use $db

// Use $db, not $dbname
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Optional: charset set (recommended)
$conn->set_charset("utf8");
?>
