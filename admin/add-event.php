<?php include "components/sidebar.php"; ?>



<?php
session_start();
if(!isset($_SESSION['admin_id'])){ header("Location: adminlogin.php"); exit; }
require_once "db.php";

$success = $error = "";

if(isset($_POST['submit'])){
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date  = $_POST['event_date'];
    $image_name  = "";

    if(!empty($_FILES['image']['name'])){
        $ext        = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '_event.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image_name);
    }

    $sql = "INSERT INTO events (title, description, event_date, image)
            VALUES ('$title','$description','$event_date','$image_name')";

    if(mysqli_query($conn, $sql)){
        $success = "Event added successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Event – Admin</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .form-card { background:#fff; border-radius:14px; padding:35px; max-width:600px; box-shadow:0 4px 18px rgba(0,0,0,0.08); }
    .form-card h2 { margin:0 0 24px; color:#1e293b; font-size:1.3rem; border-left:4px solid #2563eb; padding-left:12px; }
    .fg { margin-bottom:18px; }
    .fg label { display:block; font-size:0.83rem; font-weight:600; color:#374151; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.4px; }
    .fg input, .fg textarea {
      width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:8px;
      font-size:0.93rem; font-family:inherit; background:#f8fafc; outline:none; transition:0.2s;
    }
    .fg input:focus, .fg textarea:focus { border-color:#2563eb; background:#fff; box-shadow:0 0 0 3px rgba(37,99,235,0.1); }
    .fg textarea { resize:vertical; min-height:110px; }
    .btn-submit { background:linear-gradient(135deg,#2563eb,#1d4ed8); color:white; border:none; padding:13px 32px; border-radius:8px; font-size:1rem; font-weight:600; cursor:pointer; transition:0.3s; }
    .btn-submit:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(37,99,235,0.35); }
    .alert { padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:500; }
    .alert.success { background:#dcfce7; border:1px solid #86efac; color:#166534; }
    .alert.error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
    .manage-link { display:inline-block; margin-top:16px; color:#2563eb; text-decoration:none; font-weight:600; }
  </style>
</head>
<body >


<div class="main">
  <h1>Add New Event</h1>

  <?php if($success): ?><div class="alert success">✅ <?php echo $success; ?></div><?php endif; ?>
  <?php if($error):   ?><div class="alert error">⚠️ <?php echo $error; ?></div><?php endif; ?>

  <div class="form-card">
    <h2>Event Details</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="fg">
        <label>Event Title *</label>
        <input type="text" name="title" placeholder="e.g. Diwali Mela 2026" required>
      </div>
      <div class="fg">
        <label>Event Date *</label>
        <input type="date" name="event_date" required>
      </div>
      <div class="fg">
        <label>Description *</label>
        <textarea name="description" placeholder="Describe the event..." required></textarea>
      </div>
      <div class="fg">
        <label>Event Image</label>
        <input type="file" name="image" accept="image/*">
      </div>
      <button type="submit" name="submit" class="btn-submit">➕ Add Event</button>
    </form>
    <a href="manage-event.php" class="manage-link">→ View All Events</a>
  </div>
</div>

</body>
</html>