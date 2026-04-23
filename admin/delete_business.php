<?php if(isset($_GET['deleted'])){ ?>
<script>
alert("Business deleted successfully!");
</script>
<?php } ?>


<?php
include("../db.php");

/* CHECK ID */
if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = $_GET['id'];

/* DELETE GALLERY FIRST */
mysqli_query($conn, "DELETE FROM business_images WHERE business_id='$id'");

/* DELETE BUSINESS */
mysqli_query($conn, "DELETE FROM businesses WHERE id='$id'");

/* REDIRECT BACK */
header("Location: businesss.php");
exit();
?>