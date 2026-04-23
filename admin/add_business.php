<?php
session_start();
include "db.php";

/* =========================
   LOGIN CHECK
========================= */
if(!isset($_SESSION['user_id'])){
    die("Login required to add business.");
}

$user_id = $_SESSION['user_id'];

/* =========================
   FORM CHECK
========================= */
if(isset($_POST['name'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $owner = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategory_id = mysqli_real_escape_string($conn, $_POST['subcategory_id']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = isset($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : '';
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $image = "";

    // IMAGE UPLOAD
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $folder = __DIR__ . "/../uploads/";

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $folder . $image);
    }

    // INSERT
    $sql = "INSERT INTO businesses 
    (name, owner_name, category, subcategory_id, phone, email, website, address, city, description, image, user_id, status)
    VALUES 
    ('$name', '$owner', '$category', '$subcategory_id', '$phone', '$email', '$website', '$address', '$city', '$description', '$image', '$user_id', 'pending')";

    if(mysqli_query($conn, $sql)){

        $business_id = mysqli_insert_id($conn);

        // GALLERY UPLOAD
        if(isset($_FILES['images']['name'][0]) && $_FILES['images']['name'][0] != ""){

            foreach($_FILES['images']['name'] as $key => $value){

                $img_name = time() . "_" . basename($_FILES['images']['name'][$key]);
                $tmp = $_FILES['images']['tmp_name'][$key];

                move_uploaded_file($tmp, "../uploads/" . $img_name);

                mysqli_query($conn, "INSERT INTO business_images (business_id, image)
                VALUES ('$business_id', '$img_name')");
            }
        }

        header("Location: ../index.php?added=1");
        exit();

    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
/* =========================
   GALLERY IMAGES UPLOAD
========================= */
       if(mysqli_query($conn, $sql)){

    $business_id = mysqli_insert_id($conn);

    // GALLERY UPLOAD
    if(isset($_FILES['images']['name'][0]) && $_FILES['images']['name'][0] != ""){

        foreach($_FILES['images']['name'] as $key => $value){

            $img_name = time() . "_" . basename($_FILES['images']['name'][$key]);
            $tmp = $_FILES['images']['tmp_name'][$key];

            move_uploaded_file($tmp, "../uploads/" . $img_name);

            mysqli_query($conn, "INSERT INTO business_images (business_id, image)
            VALUES ('$business_id', '$img_name')");
        }
    }

    header("Location: ../index.php?added=1");
    exit();

} else {
    die("Database Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
</head>

<body style="margin:0;font-family:Arial;background:#f5f5f5;">

<?php if(isset($success)){ ?>

<div style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;">

    <div style="background:white;padding:40px;border-radius:10px;text-align:center;width:350px;box-shadow:0 10px 25px rgba(0,0,0,0.3);">

        <h2 style="color:#28a745;margin-bottom:10px;">✔ Success</h2>

        <p style="font-size:16px;margin-bottom:20px;">
            Business Added Successfully
        </p>

        <a href="/directories/index.php" style="background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
            Go Home
        </a>

    </div>

</div>

<?php } ?>

</body>
</html>