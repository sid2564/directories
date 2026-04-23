<?php
session_start();
include "db.php";

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message)
            VALUES ('$name', '$email', '$message')";

    if(mysqli_query($conn, $sql)){
        $success = "Message sent successfully!";
    } else {
        $error = "Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body{
            font-family: Arial;
             background-color: #b9b9b9;
        }

        .box{
            width:350px;
            margin:80px auto;
            background:#fff;
            
            padding:20px;
            border-radius:10px;
              box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        input, textarea{
            width:100%;
            padding:10px;
            margin:10px 0;
            border:1px solid #ccc;
            border-radius:5px;
        }

        button{
            width:100%;
            padding:10px;
            background:#ff4d4d;
            color:#fff;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        .msg{ color:green; }
        .err{ color:red; }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="box">
    <h2>Contact Us</h2>

    <?php if(isset($success)) echo "<p class='msg'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='err'>$error</p>"; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" required></textarea>

        <button type="submit" name="send">Send Message</button>
    </form>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>