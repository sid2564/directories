<?php
session_start();
include "db.php";

// 🔥 VERIFY LOGIN (Add Business ke liye)
if(isset($_POST['action']) && $_POST['action'] == 'verify'){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $_SESSION['verified'] = true;
      $_SESSION['open_business_modal'] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials for verification";
    }
}


// 🔥 NORMAL LOGIN
if(isset($_POST['email']) && !isset($_POST['action'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['fullname'];
        $_SESSION['email'] = $row['email'];
        // $_SESSION['verified'] = false; // ❌ abhi verify nahi

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid Email or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
body{
  font-family: Arial, sans-serif;
}

/* modal background */
#loginModal{
  display:none;
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.6);
  z-index:9999;
  justify-content:center;
  align-items:center;
}

/* modal box */
.modal-box{
  background:white;
  padding:25px;
  border-radius:10px;
  width:350px;
  text-align:center;
}

.close{
  float:right;
  font-size:26px;
  cursor:pointer;
}

input{
  width:100%;
  padding:10px;
  margin:10px 0;
  border-radius:5px;
  border:1px solid #ccc;
}

button{
  width:100%;
  padding:10px;
  background:#007bff;
  color:white;
  border:none;
  border-radius:5px;
  cursor:pointer;
}
button:hover{
  background:#0056b3;
}
</style>
</head>

<body>

<!-- LOGIN MODAL -->
<div id="loginModal">
  <div class="modal-box">

    <span class="close">&times;</span>

    <h2>Login</h2>

    <?php if(isset($error)) { ?>
      <p style="color:red;"><?php echo $error; ?></p>
    <?php } ?>

    <form action="index.php" method="post">
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="hidden" name="verify_business" value="1">
      <input type="password" name="password" placeholder="Enter Password" required>
      <input type="hidden" name="action" value="verify">
      <button type="submit">Login</button>
    </form>

  </div>
</div>

<script>
const modal = document.getElementById("loginModal");
const closeBtn = document.querySelector(".close");

// open modal
function openModal(){
  modal.style.display = "flex";
}

// close modal
function closeModal(){
  modal.style.display = "none";
}

closeBtn.onclick = closeModal;

// ✅ Show popup ONLY if NOT logged in
<?php if(!isset($_SESSION['user'])) { ?>
setTimeout(openModal, 3000); // show after 3 sec
<?php } ?>

</script>

</body>
</html>