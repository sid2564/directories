<?php
include "db.php";

$subcategory_id = $_GET['id'];

$sql = "SELECT * FROM businesses WHERE subcategory_id='$subcategory_id'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){
?>

<div class="business-card">

<div class="business-img">
<img src="uploads/<?php echo $row['image']; ?>">
</div>

<div class="business-info">

<h2><?php echo $row['name']; ?></h2>

<p>📍 <?php echo $row['address']; ?></p>

<p><?php echo $row['description']; ?></p>

<div class="business-buttons">

<a href="tel:<?php echo $row['phone']; ?>" class="btn-call">Show Number</a>

<a href="<?php echo $row['website']; ?>" class="btn-order">Order Online</a>

<a href="https://wa.me/<?php echo $row['phone']; ?>" class="btn-whatsapp">WhatsApp</a>

</div>

</div>

</div>

<?php } ?>