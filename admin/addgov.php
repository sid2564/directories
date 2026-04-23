<?php
include "../db.php";

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $update_date = $_POST['update_date'];

    $sql = "INSERT INTO government_updates (title, description, update_date)
            VALUES ('$title','$description','$update_date')";

    mysqli_query($conn,$sql);

    header("Location: manage-updates.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Government Update</title>
<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.form-box{
    background:#fff;
    padding:30px;
    width:400px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
}
input,textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #ccc;
}
button{
    width:100%;
    padding:10px;
    background:#111827;
    color:#fff;
    border:none;
    border-radius:6px;
}
</style>
</head>
<body>

<div class="form-box">
<h2>Add Government Update</h2>

<form method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <input type="date" name="update_date" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <button type="submit" name="submit">Add Update</button>
</form>
</div>

</body>
</html>