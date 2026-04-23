<?php
// logout.php - Destroys the session and sends user back to home page
session_start();
session_destroy();
header("Location: index.php");
exit();
?>