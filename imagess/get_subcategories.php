<?php

include "db.php";

if(isset($_POST['category'])){

$category = $_POST['category'];

$sql = "SELECT * FROM subcategories WHERE category='$category'";

$result = mysqli_query($conn,$sql);

echo "<option value=''>Select Subcategory</option>";

while($row=mysqli_fetch_assoc($result)){

echo "<option value='".$row['id']."'>".$row['subcategory_name']."</option>";

}

}

?>