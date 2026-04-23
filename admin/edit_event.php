<?php include "components/sidebar.php"; ?>


<?php
session_start();
if(!isset($_SESSION['admin_id'])){ header("Location: adminlogin.php"); exit; }
require_once "db.php";

$eid = (int)$_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM events WHERE id=$eid"));
if(!$row){ header("Location: manage-event.php"); exit; }

$success = $error = "";

if(isset($_POST['update'])){
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date  = $_POST['event_date'];
    $image_name  = $row['image'];

    if(!empty($_FILES['image']['name'])){
        // Remove old image
        if(!empty($image_name) && file_exists("../uploads/".$image_name)){
            unlink("../uploads/".$image_name);
        }
        $ext        = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '_event.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image_name);
    }

    $sql = "UPDATE events SET title='$title', description='$description', event_date='$event_date', image='$image_name' WHERE id=$eid";
    if(mysqli_query($conn,$sql)){
        header("Location: manage-event.php?msg=updated"); exit;
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Event – Admin</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .form-card { background:#fff; border-radius:14px; padding:35px; max-width:600px; box-shadow:0 4px 18px rgba(0,0,0,0.08); }
    .form-card h2 { margin:0 0 24px; color:#1e293b; font-size:1.3rem; border-left:4px solid #f59e0b; padding-left:12px; }
    .fg { margin-bottom:18px; }
    .fg label { display:block; font-size:0.83rem; font-weight:600; color:#374151; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.4px; }
    .fg input, .fg textarea { width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.93rem; font-family:inherit; background:#f8fafc; outline:none; transition:0.2s; }
    .fg input:focus, .fg textarea:focus { border-color:#f59e0b; background:#fff; box-shadow:0 0 0 3px rgba(245,158,11,0.12); }
    .fg textarea { resize:vertical; min-height:110px; }
    .current-img { display:block; width:100%; max-height:200px; object-fit:cover; border-radius:8px; margin-bottom:10px; }
    .btn-submit { background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; padding:13px 32px; border-radius:8px; font-size:1rem; font-weight:600; cursor:pointer; transition:0.3s; }
    .btn-submit:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(245,158,11,0.35); }
    .btn-cancel { margin-left:12px; color:#64748b; text-decoration:none; font-weight:500; }
    .alert.error { padding:12px 16px; border-radius:8px; margin-bottom:20px; background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
  </style>
</head>
<body>

<div class="main">
  <h1>✏️ Edit Event</h1>
  <?php if($error): ?><div class="alert error">⚠️ <?php echo $error; ?></div><?php endif; ?>

  <div class="form-card">
    <h2>Update Event #<?php echo $eid; ?></h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="fg">
        <label>Event Title *</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
      </div>
      <div class="fg">
        <label>Event Date *</label>
        <input type="date" name="event_date" value="<?php echo $row['event_date']; ?>" required>
      </div>
      <div class="fg">
        <label>Description *</label>
        <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
      </div>
      <div class="fg">
        <label>Event Image (leave blank to keep current)</label>
        <?php if(!empty($row['image'])): ?>
          <img src="../uploads/<?php echo $row['image']; ?>" class="current-img" alt="current">
        <?php endif; ?>
        <input type="file" name="image" accept="image/*">
      </div>
      <button type="submit" name="update" class="btn-submit">💾 Update Event</button>
      <a href="manage-event.php" class="btn-cancel">Cancel</a>
    </form>
  </div>
</div>

</body>
</html>