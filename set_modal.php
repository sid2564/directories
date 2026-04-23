<?php
session_start();
$_SESSION['open_business_modal'] = true;
header("Location: index.php");
exit;
?>