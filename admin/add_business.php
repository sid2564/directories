<?php
session_start();
include __DIR__ . "/../db.php";
if(!isset($conn)){
    die("Database connection failed");
}
/* =========================
   LOGIN CHECK (SAFE REDIRECT)
========================= */
if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   FORM SUBMIT HANDLING
========================= */
if(isset($_POST['name'])){

    $name = mysqli_real_escape_string($conn ?? die("DB error"), $_POST['name']);
    $owner           = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $category        = mysqli_real_escape_string($conn, $_POST['category']);
    $subcategory_id  = mysqli_real_escape_string($conn, $_POST['subcategory_id']);
    $phone           = mysqli_real_escape_string($conn, $_POST['phone']);
    $email           = mysqli_real_escape_string($conn, $_POST['email']);
    $website         = mysqli_real_escape_string($conn, $_POST['website']);
    $address         = mysqli_real_escape_string($conn, $_POST['address']);
    $city            = isset($_POST['city']) ? mysqli_real_escape_string($conn, $_POST['city']) : '';
    $description     = mysqli_real_escape_string($conn, $_POST['description']);

    $image = "";

/* =========================
   SINGLE IMAGE UPLOAD
========================= */
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){

        $folder = "../uploads/";

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $folder . $image);
    }

/* =========================
   INSERT BUSINESS
========================= */
    $sql = "INSERT INTO businesses 
    (name, owner_name, category, subcategory_id, phone, email, website, address, city, description, image, user_id, status)
    VALUES 
    ('$name', '$owner', '$category', '$subcategory_id', '$phone', '$email', '$website', '$address', '$city', '$description', '$image', '$user_id', 'pending')";

    if(mysqli_query($conn, $sql)){

        $business_id = mysqli_insert_id($conn);

/* =========================
   MULTIPLE GALLERY IMAGES
========================= */
        if(isset($_FILES['images']['name'][0]) && $_FILES['images']['name'][0] != ""){

            foreach($_FILES['images']['name'] as $key => $value){

                $img_name = time() . "_" . basename($_FILES['images']['name'][$key]);
                $tmp      = $_FILES['images']['tmp_name'][$key];

                move_uploaded_file($tmp, "../uploads/" . $img_name);

                mysqli_query($conn, "INSERT INTO business_images (business_id, image)
                VALUES ('$business_id', '$img_name')");
            }
        }

/* =========================
   SUCCESS REDIRECT
========================= */
        header("Location: ../index.php?added=1");
        exit();

    } else {
        die("Database Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Business</title>
</head>

<body style="font-family:Arial;background:#f5f5f5;">

<?php if(isset($_GET['added'])) { ?>
<div style="padding:20px;background:green;color:white;text-align:center;">
    ✔ Business Added Successfully
</div>
<?php } ?>

</body>
</html>
