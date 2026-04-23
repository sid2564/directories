<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];

// Variable values ko 'escape' karna zaroori hai taaki apostrophe (') se error na aaye
$id = mysqli_real_escape_string($conn, $_POST['id']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

/* OWNER CHECK */
$check = mysqli_query($conn, "SELECT * FROM businesses WHERE id='$id' AND user_id='$user_id'");

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

/* UPDATE QUERY (Ab ismein error nahi aayega) */
$sql = "UPDATE businesses SET 
name='$name',
phone='$phone',
city='$city',
description='$description'
$image_sql
WHERE id='$id' AND user_id='$user_id'";

if(mysqli_query($conn, $sql)){
    header("Location: my_business.php?updated=1");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
exit();
?>
