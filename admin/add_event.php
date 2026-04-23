<?php
session_start();
include "../db.php";

if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];

$title = $_POST['title'];
$event_date = $_POST['event_date'];
$location = $_POST['location'];
$description = $_POST['description'];

/* IMAGE UPLOAD */
$image_name = "";
if(!empty($_FILES['image']['name'])){
    $image_name = time().$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image_name);
}

/* INSERT QUERY */
$query = "INSERT INTO events 
(title, description, event_date, image)
VALUES 
('$title', '$description', '$event_date', '$image_name')";

if(mysqli_query($conn, $query)){
    header("Location: ../event.php");
} else {
    echo "Error: ".mysqli_error($conn);
}
?>