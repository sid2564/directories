<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f1f5f9;
}

/* SIDEBAR */
.sidebar{
    width:210px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:linear-gradient(180deg,#1e293b,#0f172a);
    color:white;
    padding-top:25px;
    box-shadow:2px 0 10px rgba(0,0,0,0.1);
}

.profile{
    text-align:center;
    font-size:18px;
    font-weight:600;
    margin-bottom:30px;
    letter-spacing:1px;
}

/* MENU */
.sidebar ul{
    list-style:none;
    padding:0;
}

.sidebar ul li{
    padding:12px 20px;
    font-size:14px;
    margin:6px 10px;
    border-radius:8px;
    transition:0.3s;
}

.sidebar ul li a{
    color:#cbd5f5;
    text-decoration:none;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.sidebar ul li:hover{
    background:#3b82f6;
}

.sidebar ul li.active{
    background:#2563eb;
}

/* MAIN CONTENT FIX */
.main-content{
    margin-left:210px;
    padding:20px;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <div class="profile">⚙️ Admin Panel</div>
  <ul>

    <li class="active">
      <a href="dashboard.php">Dashboard</a>
    </li>

    <li>
      <a href="businesss.php">Business</a>
    </li>

    <li>
      <a href="leads.php">
        <span>Leads</span>
        <?php if(!empty($newLeads) && $newLeads > 0): ?>
          <span style="background:#ef4444;color:white;border-radius:10px;padding:2px 8px;font-size:12px;">
            <?php echo $newLeads; ?>
          </span>
        <?php endif; ?>
      </a>
    </li>

    <li><a href="add-event.php">Add Event</a></li>
    <li><a href="manage-event.php">Manage Events</a></li>
    <li><a href="user.php">Users</a></li>

    <li style="margin-top:20px;">
      <a href="logout.php" style="color:#fff;">Log out</a>
    </li>

  </ul>
</div>


</body>
</html>