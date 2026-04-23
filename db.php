<?php
// db.php

$host = "localhost";
$user = "root";      // XAMPP default
$pass = "";          // XAMPP default
$dbname = "directories";  // apna DB name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Optional: charset set (recommended)
$conn->set_charset("utf8");

?>
