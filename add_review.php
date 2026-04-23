<?php
include "db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $business_id = $_POST['business_id'];
    $name        = $_POST['name'];
    $rating      = $_POST['rating'];
    $comment     = $_POST['comment'];

    // safety
    $name    = mysqli_real_escape_string($conn, $name);
    $comment = mysqli_real_escape_string($conn, $comment);

    $sql = "INSERT INTO reviews (business_id, name, rating, comment)
            VALUES ('$business_id', '$name', '$rating', '$comment')";

    if(mysqli_query($conn, $sql)){
        // redirect back
        header("Location: business_details.php?id=".$business_id);
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>