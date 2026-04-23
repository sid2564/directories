<?php
session_start();
include "db.php";
$id     = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM events WHERE id=$id");
$row    = mysqli_fetch_assoc($result);
?>
<?php include('includes/header.php'); ?>

<style>
.event-detail { max-width:800px; margin:40px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
.event-detail img { width:100%; border-radius:10px; margin-bottom:20px; }
.back-link { display:inline-block; margin-top:20px; color:#ff4d4d; text-decoration:none; font-weight:bold; }
</style>

<div class="event-detail">
  <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
  <h1><?php echo $row['title']; ?></h1>
  <p><strong>Date:</strong> <?php echo $row['event_date']; ?></p>
  <p><?php echo $row['description']; ?></p>
  <a href="event.php" class="back-link">← Back to Events</a>
</div>

<?php include('includes/footer.php'); ?>