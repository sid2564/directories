<?php
include "db.php";

$business_id = $_GET['id'];

if(isset($_POST['upload'])){

$folder = "uploads/";

$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

$newname = time()."_".$image;

move_uploaded_file($tmp,$folder.$newname);

mysqli_query($conn,"INSERT INTO business_images(business_id,image)
VALUES('$business_id','$newname')");

echo "Image Added Successfully";
}
?>

<h2>Add More Images</h2>

<form method="post" enctype="multipart/form-data">

<input type="file" name="image" required>

<br><br>

<button name="upload">Upload Image</button>

</form>