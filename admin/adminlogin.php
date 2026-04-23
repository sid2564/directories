<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    if ($name == "" || $password == "") {
        $error = "All fields are required";
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE name=? AND password=?");
        $stmt->bind_param("ss", $name, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header("Location: ../admin/dashboard.php");
            exit;
        } else {
            $error = "Invalid login details";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="login-box">
  <h2>Admin Login</h2>

  <?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="post">
    <input type="text" name="name" placeholder="Admin Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
