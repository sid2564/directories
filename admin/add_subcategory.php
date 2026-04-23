<?php
include "../db.php";

if(isset($_POST['submit'])){

    $category_id = $_POST['category_id'];
    $subcategory_name = $_POST['subcategory_name'];

    $query = "INSERT INTO subcategories (category_id, subcategory_name)
              VALUES ('$category_id', '$subcategory_name')";

    mysqli_query($conn, $query);

    echo "<script>alert('Subcategory Added Successfully');</script>";
}
?>

<h2>Add Subcategory</h2>

<form method="POST">

    <label>Select Category</label>
    <select name="category_id" required>
        <option value="">Select Category</option>

        <?php
        $cat = mysqli_query($conn, "SELECT * FROM categories");
        while($row = mysqli_fetch_assoc($cat)){
        ?>
            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['category_name']; ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Subcategory Name</label>
    <input type="text" name="subcategory_name" required>

    <br><br>

    <button type="submit" name="submit">Add Subcategory</button>

</form>