<?php
session_start();
if(!isset($_SESSION['admin_id'])){ header("Location: adminlogin.php"); exit; }
require_once "db.php";

$result = mysqli_query($conn,"SELECT COUNT(*) AS c FROM businesses");
$row = mysqli_fetch_assoc($result);
$totalBiz = $row ? $row['c'] : 0;
// Total Businesses
$res1 = mysqli_query($conn,"SELECT COUNT(*) AS c FROM businesses");
$totalBiz = mysqli_fetch_assoc($res1)['c'] ?? 0;

// Pending
$res2 = mysqli_query($conn,"SELECT COUNT(*) AS c FROM businesses WHERE status='pending'");
$pendingBiz = mysqli_fetch_assoc($res2)['c'] ?? 0;

// Users
$res3 = mysqli_query($conn,"SELECT COUNT(*) AS c FROM users");
$usersCount = mysqli_fetch_assoc($res3)['c'] ?? 0;
// Reviews count
$resReviews = mysqli_query($conn,"SELECT COUNT(*) AS c FROM reviews");
$reviewsCount = mysqli_fetch_assoc($resReviews)['c'] ?? 0;

// Approved businesses
$resApproved = mysqli_query($conn,"SELECT COUNT(*) AS c FROM businesses WHERE status='approved'");
$approvedBiz = mysqli_fetch_assoc($resApproved)['c'] ?? 0;
// Leads
$res4 = mysqli_query($conn,"SELECT COUNT(*) AS c FROM leads");
$leadsCount = mysqli_fetch_assoc($res4)['c'] ?? 0;
// Only query if leads table exists
$tbl = mysqli_query($conn,"SHOW TABLES LIKE 'leads'");
if(mysqli_num_rows($tbl) > 0){
    $leadsCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS c FROM leads"))['c'];
    $newLeads   = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS c FROM leads WHERE status='new'"))['c'];
}
$eventsCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS c FROM events"))['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:18px; margin-bottom:30px; }
    .card  { background:#fff; padding:22px; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.06); text-align:center; border-top:4px solid #e2e8f0; transition:0.3s; }
    .card:hover { transform:translateY(-4px); }
    .card.blue  { border-color:#2563eb; } .card.blue  h2 { color:#2563eb; }
    .card.red   { border-color:#ef4444; } .card.red   h2 { color:#ef4444; }
    .card.green { border-color:#22c55e; } .card.green h2 { color:#22c55e; }
    .card.yellow{ border-color:#f59e0b; } .card.yellow h2{ color:#f59e0b; }
    .card.purple{ border-color:#8b5cf6; } .card.purple h2{ color:#8b5cf6; }
    .card.pink  { border-color:#ec4899; } .card.pink  h2{ color:#ec4899; }
    .card h2 { font-size:2rem; margin-bottom:5px; }
    .card p  { color:#64748b; font-size:0.82rem; }
    .card .badge-new { display:inline-block; background:#fef2f2; color:#dc2626; font-size:0.72rem; font-weight:700; padding:2px 8px; border-radius:10px; margin-top:4px; }
  </style>
</head>
<body class="dashboard-body">

<?php include "components/sidebar.php"; ?>

<div class="main">
  <h1>Dashboard</h1>

  <div class="cards">
    <div class="card blue">
      <h2><?php echo $totalBiz; ?></h2>
      <p>Total Businesses</p>
    </div>
    <div class="card red">
      <h2><?php echo $pendingBiz; ?></h2>
      <p>Pending Approval</p>
    </div>
    <div class="card green">
      <h2><?php echo $leadsCount; ?></h2>
      <p>Total Leads</p>
      <?php if($newLeads > 0): ?>
        <span class="badge-new"><?php echo $newLeads; ?> new</span>
      <?php endif; ?>
    </div>
    <div class="card yellow">
      <h2><?php echo $eventsCount; ?></h2>
      <p>Events</p>
    </div>
    <div class="card purple">
      <h2><?php echo $reviewsCount; ?></h2>
      <p>Reviews</p>
    </div>
    <div class="card green">
  <h2><?php echo $approvedBiz; ?></h2>
  <p>Approved Businesses</p>
</div>
    <div class="card pink">
      <h2><?php echo $usersCount; ?></h2>
      <p>Users</p>
    </div>
  </div>

  <!-- Recent Businesses Table -->
  <div class="chart">
    <h3>Recent Business Listings</h3>
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Owner</th><th>Phone</th><th>Category</th><th>Status</th><th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $biz = mysqli_query($conn,"SELECT * FROM businesses ORDER BY id DESC LIMIT 10");
        while($row = mysqli_fetch_assoc($biz)):
        ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['owner_name']; ?></td>
          <td><?php echo $row['phone']; ?></td>
          <td><?php echo $row['category']; ?></td>
          <td>
            <?php if($row['status']=='approved'): ?>
              <span style="color:#22c55e;font-weight:700;">✅ Approved</span>
            <?php else: ?>
              <a href="approve.php?id=<?php echo $row['id']; ?>"
                 style="background:#22c55e;color:white;padding:5px 10px;text-decoration:none;border-radius:6px;font-size:0.8rem;">
                 Approve
              </a>
            <?php endif; ?>
          </td>
          <td><?php echo date('d M y', strtotime($row['created_at'])); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Recent Leads -->
  <?php if($leadsCount > 0): ?>
  <div class="chart" style="margin-top:24px;">
    <h3>Recent Leads <a href="leads.php" style="font-size:0.85rem;color:#2563eb;font-weight:500;margin-left:10px;">View All →</a></h3>
    <table>
      <thead>
        <tr><th>Name</th><th>Business</th><th>Phone</th><th>Status</th><th>Date</th></tr>
      </thead>
      <tbody>
        <?php
        $rl = mysqli_query($conn,"SELECT l.*, b.name AS bname FROM leads l LEFT JOIN businesses b ON l.business_id=b.id ORDER BY l.id DESC LIMIT 5");
        while($l = mysqli_fetch_assoc($rl)):
        ?>
        <tr>
          <td><?php echo $l['name']; ?></td>
          <td><?php echo $l['bname'] ?? '—'; ?></td>
          <td><?php echo $l['phone']; ?></td>
          <td><span style="background:<?php echo $l['status']==='new'?'#fef2f2':($l['status']==='contacted'?'#fffbeb':'#f0fdf4'); ?>;color:<?php echo $l['status']==='new'?'#dc2626':($l['status']==='contacted'?'#b45309':'#15803d'); ?>;padding:3px 10px;border-radius:12px;font-size:0.78rem;font-weight:700;"><?php echo ucfirst($l['status']); ?></span></td>
          <td><?php echo date('d M y', strtotime($l['created_at'])); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>

</div>
</body>
</html>