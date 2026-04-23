<?php
include "../db.php";
$result = mysqli_query($conn,"SELECT * FROM government_updates ORDER BY update_date DESC");
?>

<h2>Manage Government Updates</h2>
<a href="add-update.php">Add New Update</a><br><br>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Date</th>
    <th>Delete</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['update_date']; ?></td>
    <td>
        <a href="delete-update.php?id=<?php echo $row['id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>

</table>