<?php
include "../db.php";

$query = "SELECT subcategories.*, categories.category_name
          FROM subcategories
          JOIN categories ON subcategories.category_id = categories.id";

$result = mysqli_query($conn, $query);
?>

<h2>Subcategory List</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Category</th>
    <th>Subcategory</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['category_name']; ?></td>
    <td><?php echo $row['subcategory_name']; ?></td>
</tr>
<?php } ?>

</table>