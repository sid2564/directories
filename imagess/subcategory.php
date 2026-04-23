<?php
session_start();
include "db.php";
$subcategory_id = $_GET['id'];
$sql    = "SELECT * FROM businesses WHERE subcategory_id='$subcategory_id' AND status='approved'";
$result = mysqli_query($conn, $sql);
?>
<?php include('includes/header.php'); ?>

<style>
.subcat-page { padding:30px 5%; background:#f4f6f9; min-height:60vh; }
.subcat-page h2 { text-align:center; margin-bottom:30px; }
.biz-grid { max-width:1100px; margin:auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px; }
.biz-card { border:1px solid #ddd; padding:15px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); background:white; }
.biz-card img { width:100%; height:180px; object-fit:cover; border-radius:8px; }
.biz-card a { text-decoration:none; color:black; }
.show-btn { background:red; color:white; padding:8px 15px; border:none; border-radius:5px; cursor:pointer; margin-top:8px; }
</style>

<div class="subcat-page">
  <h2>Businesses</h2>
  <div class="biz-grid">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <div class="biz-card">
        <a href="business_details.php?id=<?php echo $row['id']; ?>">
          <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
          <h3><?php echo $row['name']; ?></h3>
        </a>
        <p><?php echo $row['description']; ?></p>
        <p><b>Owner:</b> <?php echo $row['owner_name']; ?></p>
        <button class="show-btn" onclick="toggleNumber(<?php echo $row['id']; ?>)">Show Number</button>
        <p id="phone<?php echo $row['id']; ?>" style="display:none;margin-top:5px;">
          📞 <?php echo $row['phone']; ?>
        </p>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
function toggleNumber(id){
  var p = document.getElementById("phone"+id);
  p.style.display = p.style.display === "none" ? "block" : "none";
}
</script>

<?php include('includes/footer.php'); ?>