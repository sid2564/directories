<?php
session_start();
include "db.php";



if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];

$id = $_POST['id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$description = $_POST['description'];

/* OWNER CHECK */
$check = mysqli_query($conn,
"SELECT * FROM businesses WHERE id='$id' AND user_id='$user_id'");

if(mysqli_num_rows($check) == 0){
    die("Not allowed");
}

/* IMAGE UPLOAD */
$image_sql = "";

if(!empty($_FILES['image']['name'])){

    $img = time()."_".$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$img);

    $image_sql = ", image='$img'";
}

/* UPDATE QUERY */
$sql = "UPDATE businesses SET 
name='$name',
phone='$phone',
city='$city',
description='$description'
$image_sql
WHERE id='$id' AND user_id='$user_id'";

mysqli_query($conn,$sql);

header("Location: my_business.php?updated=1");
exit();
?>