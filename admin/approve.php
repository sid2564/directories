<?php
include "db.php";

$id = $_GET['id'];

$sql = "UPDATE businesses SET status='approved' WHERE id='$id'";
mysqli_query($conn, $sql);

header("Location: dashboard.php");
?>