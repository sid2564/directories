<?php
session_start();
include "db.php";
$sql    = "SELECT * FROM government_updates ORDER BY update_date DESC";
$result = mysqli_query($conn, $sql);
?>
<?php include('includes/header.php'); ?>

<style>
.gov-page { background:#f4f6f9; min-height:60vh; padding-bottom:40px; }
.gov-page h1 { text-align:center; padding:30px 0; }
.update-box { background:#fff; width:80%; margin:20px auto; padding:20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.08); transition:0.3s; }
.update-box:hover { transform:translateY(-5px); }
.update-date { color:#ff4d4d; font-weight:bold; }
.update-box a { text-decoration:none; color:black; display:block; }
</style>

<div class="gov-page">
  <h1>Government Updates</h1>

  <?php if($result && mysqli_num_rows($result) > 0): ?>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <a href="update-detail.php?id=<?php echo $row['id']; ?>">
        <div class="update-box">
          <div class="update-date"><?php echo $row['update_date']; ?></div>
          <h3><?php echo $row['title']; ?></h3>
          <p><?php echo substr($row['description'], 0, 100); ?>...</p>
        </div>
      </a>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="update-box">
      <div class="update-date">15 March 2026</div>
      <h3>New Industrial Policy Announced</h3>
      <p>Government has introduced new benefits for local industries...</p>
    </div>
  <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>