<?php
include "../db.php";
$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM government_updates WHERE id=$id");
header("Location: manage-updates.php");
?>