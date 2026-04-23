<?php include "components/sidebar.php"; ?>



<?php
session_start();
if(!isset($_SESSION['admin_id'])){ header("Location: adminlogin.php"); exit; }
require_once "db.php";

// Delete event
if(isset($_GET['delete'])){
    $eid = (int)$_GET['delete'];
    // Also remove image file
    $r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT image FROM events WHERE id=$eid"));
    if(!empty($r['image']) && file_exists("../uploads/".$r['image'])){
        unlink("../uploads/".$r['image']);
    }
    mysqli_query($conn, "DELETE FROM events WHERE id=$eid");
    header("Location: manage-event.php?msg=deleted"); exit;
}

$events = mysqli_query($conn,"SELECT * FROM events ORDER BY event_date DESC");
$total  = mysqli_num_rows($events);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Events – Admin</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .top-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .btn-add { background:#2563eb; color:white; padding:10px 22px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.9rem; transition:0.2s; }
    .btn-add:hover { background:#1d4ed8; }
    .events-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
    .event-card { background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 14px rgba(0,0,0,0.07); transition:0.3s; }
    .event-card:hover { transform:translateY(-4px); box-shadow:0 8px 22px rgba(0,0,0,0.12); }
    .event-card img { width:100%; height:170px; object-fit:cover; }
    .event-card .no-img { width:100%; height:170px; background:linear-gradient(135deg,#1e293b,#3b82f6); display:flex; align-items:center; justify-content:center; font-size:3rem; }
    .event-card .card-body { padding:16px; }
    .event-card h3 { margin:0 0 6px; font-size:1rem; color:#1e293b; }
    .event-card .date { color:#ef4444; font-size:0.83rem; font-weight:600; margin-bottom:8px; }
    .event-card .desc { color:#64748b; font-size:0.83rem; line-height:1.5; margin-bottom:14px; }
    .card-actions { display:flex; gap:8px; }
    .act { padding:7px 14px; border-radius:6px; font-size:0.82rem; font-weight:600; text-decoration:none; }
    .act.edit { background:#eff6ff; color:#2563eb; }
    .act.del  { background:#fef2f2; color:#dc2626; }
    .act:hover { opacity:0.8; }
    .alert { padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:500; background:#dcfce7; border:1px solid #86efac; color:#166534; }
    .empty { text-align:center; padding:60px; color:#94a3b8; font-size:1.1rem; }
  </style>
</head>
<body>

<div class="main">
  <div class="top-bar">
    <h1>🎉 Events (<?php echo $total; ?>)</h1>
    <a href="add-event.php" class="btn-add">➕ Add New Event</a>
  </div>

  <?php if(isset($_GET['msg'])): ?>
    <div class="alert">✅ Event <?php echo $_GET['msg']; ?> successfully.</div>
  <?php endif; ?>

  <?php if($total == 0): ?>
    <div class="empty">No events yet. <a href="add-event.php">Add one now →</a></div>
  <?php else: ?>
  <div class="events-grid">
    <?php while($row = mysqli_fetch_assoc($events)): ?>
    <div class="event-card">
      <?php if(!empty($row['image'])): ?>
        <img src="../uploads/<?php echo $row['image']; ?>" alt="event">
      <?php else: ?>
        <div class="no-img">🎉</div>
      <?php endif; ?>
      <div class="card-body">
        <div class="date">📅 <?php echo date('d M Y', strtotime($row['event_date'])); ?></div>
        <h3><?php echo $row['title']; ?></h3>
        <p class="desc"><?php echo mb_substr($row['description'],0,90).'…'; ?></p>
        <div class="card-actions">
          <a href="edit_event.php?id=<?php echo $row['id']; ?>" class="act edit">✏️ Edit</a>
          <a href="manage-event.php?delete=<?php echo $row['id']; ?>" class="act del"
             onclick="return confirm('Delete this event?')">🗑️ Delete</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
  <?php endif; ?>
</div>

</body>
</html>