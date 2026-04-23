<?php
session_start();
include "db.php";
$category = $_GET['cat'] ?? '';
$sql      = "SELECT * FROM subcategories WHERE category_id=(SELECT id FROM categories WHERE name='$category')";
$result   = mysqli_query($conn, $sql);
?>
<?php include('includes/header.php'); ?>

<style>
.cat-page { padding:40px 5%; background:#f4f6f9; min-height:60vh; }
.cat-page h2 { text-align:center; margin-bottom:30px; text-transform:capitalize; }
.subcat-list { max-width:800px; margin:auto; display:flex; flex-wrap:wrap; gap:15px; justify-content:center; }
.subcat-btn { background:#ff4d4d; color:white; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:bold; transition:0.3s; }
.subcat-btn:hover { background:#cc0000; }
</style>

<div class="cat-page">
  <h2><?php echo htmlspecialchars($category); ?> - Subcategories</h2>
  <div class="subcat-list">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <a href="subcategory.php?id=<?php echo $row['id']; ?>" class="subcat-btn">
        <?php echo $row['subcategory_name']; ?>
      </a>
    <?php endwhile; ?>
  </div>
</div>

<?php include('includes/footer.php'); ?>