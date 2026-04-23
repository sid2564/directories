<?php
session_start();
include "db.php";

/* =========================
   LOGIN CHECK
========================= */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   FORM SUBMIT
========================= */
if(isset($_POST['add_business'])){

    $name      = mysqli_real_escape_string($conn, $_POST['name']);
    $owner     = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $category  = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategory_id = mysqli_real_escape_string($conn, $_POST['subcategory_id']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $website   = mysqli_real_escape_string($conn, $_POST['website']);
    $address   = mysqli_real_escape_string($conn, $_POST['address']);
    $city      = mysqli_real_escape_string($conn, $_POST['city']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    /* IMAGE UPLOAD */
    $image = "";

    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){

        $folder = "uploads/";

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $folder . $image);
    }

    /* INSERT QUERY */
    $sql = "INSERT INTO businesses 
    (name, owner_name, category, subcategory_id, phone, email, website, address, city, description, image, user_id, status)
    VALUES 
    ('$name','$owner','$category','$subcategory_id','$phone','$email','$website','$address','$city','$description','$image','$user_id','pending')";

    if(mysqli_query($conn, $sql)){

        $business_id = mysqli_insert_id($conn);

        /* GALLERY */
        if(!empty($_FILES['images']['name'][0])){

            foreach($_FILES['images']['name'] as $key => $value){

                $img_name = time() . "_" . basename($value);
                $tmp = $_FILES['images']['tmp_name'][$key];

                move_uploaded_file($tmp, "uploads/" . $img_name);

                mysqli_query($conn, "INSERT INTO business_images (business_id, image)
                VALUES ('$business_id','$img_name')");
            }
        }

        header("Location: index.php?added=1");
        exit();

    } else {
        die("DB Error: " . mysqli_error($conn));
    }
}
?>

<!-- =========================
     BUSINESS FORM
========================= -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Business</title>
</head>
<body>

<h2>Add Business</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="name" placeholder="Business Name" required><br><br>

    <input type="text" name="owner_name" placeholder="Owner Name" required><br><br>

    <input type="text" name="category" placeholder="Category" required><br><br>

    <input type="text" name="subcategory_id" placeholder="Subcategory ID"><br><br>

    <input type="text" name="phone" placeholder="Phone"><br><br>

    <input type="email" name="email" placeholder="Email"><br><br>

    <input type="text" name="website" placeholder="Website"><br><br>

    <input type="text" name="address" placeholder="Address"><br><br>

    <input type="text" name="city" placeholder="City"><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>

    <input type="file" name="image"><br><br>

    <input type="file" name="images[]" multiple><br><br>

    <button type="submit" name="add_business">Submit</button>

</form>

</body>
</html>
