<?php
session_start();
include "db.php";

/* =========================
   VERIFY LOGIN (Add Business)
========================= */
if(isset($_POST['action']) && $_POST['action'] == 'verify'){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['email'] = $user['email'];

        // 🔥 trigger business modal after login
        $_SESSION['open_business_modal'] = true;

        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid credentials for verification";
    }
}


/* =========================
   NORMAL LOGIN
========================= */
if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['email'] = $user['email'];

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
<title>Login</title>

<style>
body{
  font-family: Arial, sans-serif;
}

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

    <form method="post">

      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="password" name="password" placeholder="Enter Password" required>

      <!-- verify mode -->
      <input type="hidden" name="action" value="verify">

      <button type="submit" name="login">Login</button>

    </form>

  </div>
</div>

<script>
const modal = document.getElementById("loginModal");
const closeBtn = document.querySelector(".close");

function openModal(){
  modal.style.display = "flex";
}

function closeModal(){
  modal.style.display = "none";
}

closeBtn.onclick = closeModal;

/* show only if not logged in */
<?php if(!isset($_SESSION['user_id'])) { ?>
setTimeout(openModal, 3000);
<?php } ?>
</script>

</body>
</html>
