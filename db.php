$conn = mysqli_connect(
    "MYSQLHOST",
    "MYSQLUSER",
    "MYSQLPASSWORD",
    "MYSQLDATABASE",
    MYSQLPORT
);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
