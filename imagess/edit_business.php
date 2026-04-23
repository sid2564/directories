<?php
session_start();
include "db.php";

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

/* ONLY OWNER CAN EDIT */
$query = mysqli_query($conn,
"SELECT * FROM businesses WHERE id='$id' AND user_id='$user_id'");

if(mysqli_num_rows($query) == 0){
    die("❌ You cannot edit this business");
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Business</title>

    <!-- ICONS (IMPORTANT FIX) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:Arial;
            background:lightgrey;
        }

        .container{
            max-width:600px;
            margin:0px auto;
            background:lightyellow;
            padding:30px;
            border-radius:12px;
            box-shadow:10 10px 25px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
            color:#333;
        }

        label{
            font-weight:bold;
        }

        input, textarea{
            width:100%;
            padding:10px;
            margin:8px 0 15px;
            border:1px solid #ccc;
            border-radius:6px;
        }

        button{
            width:100%;
            padding:12px;
            background:#007bff;
            color:#fff;
            border:none;
            border-radius:6px;
            font-size:16px;
            cursor:pointer;
        }

        button:hover{
            background:#0056b3;
        }

        /* BACK BUTTON */
        .back-btn{
            display:inline-flex;
            align-items:center;
            gap:6px;
            text-decoration:none;
            background:#2c3e50;
            color:#fff;
              top: 30%;   /* 👈 THIS pushes it DOWN */
    left: 20px;
            padding:8px 14px;
            border-radius:8px;
            font-size:14px;
            margin:20px;
            transition:0.3s;
        }

        .back-btn:hover{
            background:#1a252f;
            transform:translateX(-3px);
        }
    </style>
</head>

<body>

<!-- BACK BUTTON -->
<a href="my_business.php" class="back-btn">
    <span class="material-icons-outlined">arrow_back</span>
    Back
</a>

<div class="container">

    <h2>Edit Business</h2>

    <form action="update_business.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <label>Business Name</label>
        <input type="text" name="name" value="<?php echo $data['name']; ?>">

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo $data['phone']; ?>">

        <label>City</label>
        <input type="text" name="city" value="<?php echo $data['city']; ?>">

        <label>Description</label>
        <textarea name="description"><?php echo $data['description']; ?></textarea>

        <label>Change Image</label>
        <input type="file" name="image">

        <button type="submit">Update Business</button>

    </form>

</div>

</body>
</html>