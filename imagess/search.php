<?php
include "db.php";

$q = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';
$city = $_GET['city'] ?? '';

$q = trim(strtolower($q));
$category = trim(strtolower($category));
$city = trim(strtolower($city));

// 🔥 keyword mapping
$keywords = [$q];

if($q == 'coffee' || $q == 'coffe' || $q == 'cafee'){
    $keywords = ['cafe','coffee','coffee shop'];
}

if($q == 'hotel'){
    $keywords = ['hotel','restaurant','lodge'];
}

// base query
$sql = "SELECT * FROM businesses WHERE status='approved'";

// search
if(!empty($q)){
    $searchParts = [];
    foreach($keywords as $word){
        $word = mysqli_real_escape_string($conn, $word);
        $searchParts[] = "LOWER(name) LIKE '%$word%'";
        $searchParts[] = "LOWER(category) LIKE '%$word%'";
    }
    $sql .= " AND (" . implode(" OR ", $searchParts) . ")";
}

// category
if(!empty($category)){
    $sql .= " AND LOWER(category) LIKE '%$category%'";
}

// city
if(!empty($city)){
    $sql .= " AND LOWER(city) LIKE '%$city%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Results</title>

<style>
body{
    font-family: Arial;
    background:#f4f4f4;
}

.search-container {
    max-width: 900px;
    margin: 30px auto;
}

.result-card {
    display: flex;
    gap: 20px;
    background: #fff;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: 0.3s;
    align-items: center;
}

.result-card:hover {
    transform: translateY(-3px);
}

.result-img {
    width: 120px;
    height: 120px;
    border-radius: 10px;
    object-fit: cover;
}

.result-info {
    flex: 1;
}

.result-info h3 {
    margin: 0;
    color: #1e293b;
}

.result-info p {
    margin: 5px 0;
    color: #555;
    font-size: 14px;
}

.view-btn {
    display: inline-block;
    margin-top: 8px;
    padding: 6px 14px;
    background: #ef4444;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}
</style>

</head>
<body>
<?php include('includes/header.php'); ?>
<h2 style="text-align:center;">Search Results</h2>

<div class="search-container">

<?php if(mysqli_num_rows($result) > 0): ?>

    <?php while($row = mysqli_fetch_assoc($result)): ?>

    <div class="result-card">

        <!-- IMAGE -->
        <img class="result-img" src="<?php
            if(!empty($row['image']) && file_exists('uploads/'.$row['image'])){
                echo 'uploads/'.$row['image'];
            } else {
                echo 'uploads/default.png';
            }
        ?>">

        <!-- DETAILS -->
        <div class="result-info">
            <h3><?php echo $row['name']; ?></h3>

            <p>📂 <?php echo $row['category']; ?></p>

            <p>📍 <?php echo $row['city'] ?? 'Location not available'; ?></p>

            <p>📞 <?php echo $row['phone']; ?></p>

            <a class="view-btn" href="business_details.php?id=<?php echo $row['id']; ?>">
                View Details
            </a>
        </div>

    </div>

    <?php endwhile; ?>

<?php else: ?>

    <p style="text-align:center;">No results found 😢</p>

<?php endif; ?>

</div>
<?php include('includes/footer.php'); ?>
</body>
</html>