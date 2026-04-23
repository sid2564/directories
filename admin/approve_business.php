<?php
require_once "db.php";

$id = $_GET['id'];

$conn->query("UPDATE businesses SET status='approved' WHERE id='$id'");

header("Location: dashboard.php");
?>
