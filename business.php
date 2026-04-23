<?php
if(isset($_POST['add_review'])){
    $name = $_POST['user_name'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $biz_id = $_GET['id'];

    mysqli_query($conn, "
        INSERT INTO reviews (business_id, user_name, rating, review)
        VALUES ('$biz_id','$name','$rating','$review')
    ");
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Add Business</title>
<link rel="stylesheet" href="style1.css">
</head>
<body>

<section class="add-business">
<h2>Add Your Business</h2>

<form action="index.php" method="post" enctype="multipart/form-data">
<div class="form-group">
<label>Business Name *</label>
<input type="text" name="name" required>
</div>

<div class="form-group">
<label>Owner Name</label>
<input type="text" name="owner_name">
</div>

<div class="form-group">
<label>Category *</label>

<select name="category" required>

<option value="">Select Category</option>

<?php
include "db.php";

$cat = mysqli_query($conn,"SELECT * FROM categories");

while($row=mysqli_fetch_assoc($cat)){
?>

<option value="<?php echo $row['category_name']; ?>">
<?php echo $row['category_name']; ?>
</option>

<?php } ?>

</select>

</div>


<div class="form-group">
<label>Subcategory *</label>

<select name="subcategory_id" required>

<option value="">Select Subcategory</option>

<?php

$sub = mysqli_query($conn,"SELECT * FROM subcategories");

while($row=mysqli_fetch_assoc($sub)){
?>

<option value="<?php echo $row['id']; ?>">
<?php echo $row['subcategory_name']; ?>
</option>

<?php } ?>

</select>

</div>


<div class="form-group">
<label>Phone *</label>
<input type="text" name="phone" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email">
</div>

<div class="form-group">
<label>Address *</label>
<textarea name="address" required></textarea>
</div>

<button type="submit">Submit Business</button>

</form>

</section>
<form method="POST">
    <input type="text" name="user_name" placeholder="Your name" required>
    
    <select name="rating" required>
        <option value="">Rating</option>
        <option value="5">5 Star</option>
        <option value="4">4 Star</option>
        <option value="3">3 Star</option>
    </select>

    <textarea name="review" placeholder="Write review" required></textarea>

    <button type="submit" name="add_review">Submit</button>
</form>

<script>
let slider = document.querySelector(".reviews-slider");

setInterval(() => {
    if(!slider) return;

    slider.scrollBy({ left: 300, behavior: 'smooth' });

    // loop back
    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
        slider.scrollTo({ left: 0, behavior: 'smooth' });
    }
}, 3000);
</script>
</body>
</html>