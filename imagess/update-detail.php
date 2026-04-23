<?php
include "db.php";

if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM government_updates WHERE id = $id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    die("No Update Found");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $row['title']; ?></title>
<style>

body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:0;
}

.container{
    width:70%;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

h1{
    color:#2c3e50;
}

.date{
    color:#777;
    margin-bottom:20px;
}

.back-btn{
    display:inline-block;
    margin-top:30px;
    padding:10px 15px;
    background:#3498db;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.back-btn:hover{
    background:#2980b9;
}

</style>
</head>
<body>

<div class="container">
    <h1><?php echo $row['title']; ?></h1>
    <div class="date"><strong>Date:</strong> <?php echo $row['update_date']; ?></div>
    <p><?php echo $row['description']; ?></p>

    <!-- <a href="/directories/government.php" class="back-btn">← Back</a> -->
     <!-- <a href="http://localhost/directories/government.php" class="back-btn">← Back</a> -->
      <a href="goverment.php" class="back-btn">← Back</a>
</div>

</body>
</html>