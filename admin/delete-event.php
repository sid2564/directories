<?php
include "../db.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM events WHERE id=$id");

header("Location: manage-events.php");
?>