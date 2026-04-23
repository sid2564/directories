<?php
include "db.php";

$business_id = $_POST['business_id'];

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

$folder = "uploads/";

if(!is_dir($folder)){
mkdir($folder,0777,true);
}

$image_name = time()."_".$image;

move_uploaded_file($tmp,$folder.$image_name);

$sql = "INSERT INTO business_images (business_id,image)
VALUES ('$business_id','$image_name')";

mysqli_query($conn,$sql);

header("Location: business_details.php?id=".$business_id);
?>