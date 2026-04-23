<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db.php";

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* BUSINESSES */
$query = "SELECT * FROM businesses WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

/* LEADS (SAFE CHECK) */
$leads = mysqli_query($conn, "
SELECT l.*
FROM leads l
JOIN businesses b ON l.business_id = b.id
WHERE b.user_id = '$user_id'
ORDER BY l.id DESC
");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Business</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{font-family:Arial;background:#f4f4f4;}
.container{width:80%;margin:auto;padding-top:20px;}

.back-btn{
display:inline-block;margin-bottom:15px;
padding:8px 12px;background:#2c3e50;
color:#fff;text-decoration:none;border-radius:6px;
}

.card{
background:#fff;display:flex;padding:15px;
margin-bottom:15px;border-radius:10px;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.card img{
width:120px;height:120px;object-fit:cover;
border-radius:10px;
}

.info{margin-left:20px;}

.btn-outline{
border:1px solid #ff4d4d;color:#ff4d4d;
background:none;padding:8px 12px;border-radius:5px;
}

.modal{
display:none;position:fixed;inset:0;
background:rgba(0,0,0,0.6);
justify-content:center;align-items:center;
}

.modal-box{
background:#fff;width:650px;
max-height:90vh;overflow-y:auto;
padding:20px;border-radius:10px;
}

.close{float:right;font-size:24px;cursor:pointer;}
.form-group{margin-bottom:10px;}
.form-group input,.form-group select,.form-group textarea{
width:100%;padding:8px;
}
.btn-submit{
background:#ff4d4d;color:#fff;
padding:10px;border:none;width:100%;
cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<a href="index.php" class="back-btn">← Back</a>

<h2>My Business</h2>

<!-- BUSINESS LIST -->
<?php while($row = mysqli_fetch_assoc($result)) { 

$img = !empty($row['image']) ? "uploads/".$row['image'] : "uploads/default.png";

if(!file_exists($img)){
    $img = "uploads/default.png";
}
?>

<div class="card">
    <img src="<?php echo $img; ?>" alt="Business">

    <div class="info">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><i class="fa fa-location-dot"></i> <?php echo $row['city'] ?: 'N/A'; ?></p>

        <a href="edit_business.php?id=<?php echo $row['id']; ?>">
            <button class="btn-outline">Edit</button>
        </a>
    </div>
</div>

<?php } ?>

<!-- LEADS -->
<h2>Recent Leads</h2>

<?php if($leads && mysqli_num_rows($leads) > 0){ ?>
    <?php while($lead = mysqli_fetch_assoc($leads)){ ?>
        <div style="background:#fff;padding:10px;margin:10px 0;border-radius:8px;">
            <b><?php echo $lead['name']; ?></b><br>
            <?php echo $lead['email']; ?><br>
            <?php echo $lead['phone']; ?><br>
            <?php echo $lead['message']; ?>
        </div>
    <?php } ?>
<?php } else { ?>
<p>No leads found.</p>
<?php } ?>

</div>

<!-- ADD BUSINESS MODAL -->
<div class="modal" id="businessModal">
<div class="modal-box">
<span class="close" onclick="closeModal()">&times;</span>

<h2>Add Business</h2>

<form action="admin/add_business.php" method="post" enctype="multipart/form-data">

<input type="text" name="name" placeholder="Business Name" required>
<input type="text" name="owner_name" placeholder="Owner">
<input type="text" name="category" placeholder="Category" required>
<input type="text" name="subcategory_id" placeholder="Subcategory ID" required>
<input type="text" name="phone" placeholder="Phone" required>
<input type="email" name="email" placeholder="Email">
<input type="text" name="city" placeholder="City">
<textarea name="address" placeholder="Address"></textarea>

<input type="file" name="image">

<button class="btn-submit">Submit</button>

</form>

</div>
</div>

<script>
function openBusinessModal(){
document.getElementById("businessModal").style.display="flex";
}
function closeModal(){
document.getElementById("businessModal").style.display="none";
}
</script>

</body>
</html>
