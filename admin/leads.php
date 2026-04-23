<?php include "components/sidebar.php"; ?>



<?php
session_start();
if(!isset($_SESSION['admin_id'])){ header("Location: adminlogin.php"); exit; }
require_once "db.php";

// Update lead status
if(isset($_GET['status']) && isset($_GET['id'])){
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $lid    = (int)$_GET['id'];
    mysqli_query($conn, "UPDATE leads SET status='$status' WHERE id=$lid");
    header("Location: leads.php"); exit;
}
// Delete lead
if(isset($_GET['delete'])){
    $lid = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM leads WHERE id=$lid");
    header("Location: leads.php"); exit;
}

// Filter
$filter = $_GET['filter'] ?? 'all';
$where  = $filter !== 'all' ? "WHERE l.status='$filter'" : "";

$leads = mysqli_query($conn,
    "SELECT l.*, b.name AS biz_name
     FROM leads l
     LEFT JOIN businesses b ON l.business_id = b.id
     $where
     ORDER BY l.created_at DESC");

$counts = [];
foreach(['new','contacted','closed'] as $s){
    $r = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS c FROM leads WHERE status='$s'"));
    $counts[$s] = $r['c'];
}
$total = array_sum($counts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leads – Admin</title>
  <link rel="stylesheet" href="dashboard.css">
  <style>
    .leads-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
    .filter-tabs { display:flex; gap:8px; flex-wrap:wrap; }
    .filter-tab {
      padding:7px 18px; border-radius:20px; text-decoration:none; font-size:0.85rem; font-weight:600;
      background:#f1f5f9; color:#475569; border:1.5px solid #e2e8f0; transition:0.2s;
    }
    .filter-tab:hover, .filter-tab.active { background:#1e293b; color:white; border-color:#1e293b; }
    .filter-tab.new.active    { background:#ef4444; border-color:#ef4444; }
    .filter-tab.contacted.active { background:#f59e0b; border-color:#f59e0b; }
    .filter-tab.closed.active { background:#22c55e; border-color:#22c55e; }

    .stat-row { display:flex; gap:16px; margin-bottom:28px; flex-wrap:wrap; }
    .stat-chip { background:#fff; border-radius:10px; padding:16px 22px; box-shadow:0 2px 8px rgba(0,0,0,0.06); flex:1; min-width:130px; text-align:center; }
    .stat-chip .num { font-size:1.8rem; font-weight:700; }
    .stat-chip .lbl { font-size:0.8rem; color:#64748b; margin-top:2px; }
    .stat-chip.total .num { color:#1e293b; }
    .stat-chip.new-s .num { color:#ef4444; }
    .stat-chip.cont .num  { color:#f59e0b; }
    .stat-chip.cls  .num  { color:#22c55e; }

    .leads-table { width:100%; border-collapse:collapse; font-size:0.88rem; }
    .leads-table th { background:#1e293b; color:white; padding:13px 14px; text-align:left; }
    .leads-table td { padding:12px 14px; border-bottom:1px solid #f1f5f9; vertical-align:top; }
    .leads-table tr:hover td { background:#f8fafc; }
    .leads-table .biz { font-weight:600; color:#1e293b; }
    .leads-table .contact { color:#475569; font-size:0.83rem; }

    .badge {
      display:inline-block; padding:3px 11px; border-radius:20px; font-size:0.78rem; font-weight:700;
    }
    .badge.new       { background:#fef2f2; color:#dc2626; }
    .badge.contacted { background:#fffbeb; color:#b45309; }
    .badge.closed    { background:#f0fdf4; color:#15803d; }

    .actions { display:flex; gap:6px; flex-wrap:wrap; }
    .act-btn {
      padding:5px 11px; border-radius:6px; font-size:0.78rem; font-weight:600;
      text-decoration:none; cursor:pointer; border:none;
    }
    .act-btn.cont { background:#fef3c7; color:#92400e; }
    .act-btn.close-b { background:#dcfce7; color:#166534; }
    .act-btn.del  { background:#fef2f2; color:#dc2626; }
    .act-btn:hover { opacity:0.8; }

    .msg-preview { color:#64748b; font-size:0.83rem; max-width:220px; }
    .empty-state { text-align:center; padding:50px; color:#94a3b8; }
    .chart {
    max-height: 400px;
    overflow-y: auto;
}

.main {
    height: 100vh;
    overflow-y: auto;
}

.leads-table thead th {
    position: sticky;
    top: 0;
    z-index: 2;
}
  </style>
</head>
<body>


<div class="main">
  <div class="leads-header">
    <h1>📋 Leads & Enquiries</h1>
    <div class="filter-tabs">
      <a href="leads.php" class="filter-tab <?php echo $filter==='all'?'active':''; ?>">All (<?php echo $total; ?>)</a>
      <a href="leads.php?filter=new" class="filter-tab new <?php echo $filter==='new'?'active':''; ?>">New (<?php echo $counts['new']; ?>)</a>
      <a href="leads.php?filter=contacted" class="filter-tab contacted <?php echo $filter==='contacted'?'active':''; ?>">Contacted (<?php echo $counts['contacted']; ?>)</a>
      <a href="leads.php?filter=closed" class="filter-tab closed <?php echo $filter==='closed'?'active':''; ?>">Closed (<?php echo $counts['closed']; ?>)</a>
    </div>
  </div>

  <div class="stat-row">
    <div class="stat-chip total"><div class="num"><?php echo $total; ?></div><div class="lbl">Total Leads</div></div>
    <div class="stat-chip new-s"><div class="num"><?php echo $counts['new']; ?></div><div class="lbl">New</div></div>
    <div class="stat-chip cont"><div class="num"><?php echo $counts['contacted']; ?></div><div class="lbl">Contacted</div></div>
    <div class="stat-chip cls"><div class="num"><?php echo $counts['closed']; ?></div><div class="lbl">Closed</div></div>
  </div>

  <div class="chart">
    <?php if(mysqli_num_rows($leads) == 0): ?>
      <div class="empty-state">📭 No leads found.</div>
    <?php else: ?>
    <table class="leads-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Business</th>
          <th>Customer</th>
          <th>Contact</th>
          <th>Message</th>
          <th>Status</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($l = mysqli_fetch_assoc($leads)): ?>
        <tr>
          <td><?php echo $l['id']; ?></td>
          <td class="biz"><?php echo $l['biz_name'] ?? '—'; ?></td>
          <td><strong><?php echo $l['name']; ?></strong></td>
          <td class="contact">
            <?php if($l['phone']): ?>📞 <?php echo $l['phone']; ?><br><?php endif; ?>
            <?php if($l['email']): ?>✉️ <?php echo $l['email']; ?><?php endif; ?>
          </td>
          <td class="msg-preview"><?php echo mb_substr($l['message'],0,80).(strlen($l['message'])>80?'…':''); ?></td>
          <td><span class="badge <?php echo $l['status']; ?>"><?php echo ucfirst($l['status']); ?></span></td>
          <td><?php echo date('d M y', strtotime($l['created_at'])); ?></td>
          <td>
            <div class="actions">
              <?php if($l['status'] !== 'contacted'): ?>
                <a href="leads.php?id=<?php echo $l['id']; ?>&status=contacted" class="act-btn cont">Contacted</a>
              <?php endif; ?>
              <?php if($l['status'] !== 'closed'): ?>
                <a href="leads.php?id=<?php echo $l['id']; ?>&status=closed" class="act-btn close-b">Close</a>
              <?php endif; ?>
              <a href="leads.php?delete=<?php echo $l['id']; ?>" class="act-btn del"
                 onclick="return confirm('Delete this lead?')">Delete</a>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

</body>
</html>