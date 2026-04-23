<?php
$conn = mysqli_connect(
    "MYSQLHOST_YAHAN",
    "MYSQLUSER_YAHAN",
    "MYSQLPASSWORD_YAHAN",
    "MYSQLDATABASE_YAHAN",
    MYSQLPORT_YAHAN
);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
