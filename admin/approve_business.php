<?php
include "../db.php";
session_start();

$id = $_GET['id'] ?? 0;

mysqli_query($conn, "UPDATE businesses SET status='approved' WHERE id='$id'");

header("Location: business.php");
exit;
?>
