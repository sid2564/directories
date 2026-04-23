
<?php include "components/sidebar.php"; ?>

<?php
include("../db.php");

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
    <title>Business Listing</title>

    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            padding:30px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }
       table{
    margin-left:210px;
    width:calc(100% - 210px);
    border-collapse:collapse;
}

/* Action column ko wide karo */
td:last-child, th:last-child{
    min-width:160px;
}
        /* table{
            width:100%;
            min-width:700px;
            display:block;
            overflow-x:auto;
        }
        table{
            margin-left:210px;
            width:calc(100% - 210px);
        } */
        th{
            background:#2c3e50;
            color:#fff;
            padding:10px;
        }

        td{
            padding:10px;
            text-align:center;
            border-bottom:1px solid #ddd;
        }

        .btn{
            padding:5px 10px;
            color:#fff;
            text-decoration:none;
            border-radius:5px;
        }

        .approve{ background:green;  }
        
        .delete{ background:red; }
    </style>
</head>
<body>

<h2>All Businesses</h2>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Owner</th>
    <th>Phone</th>
    <th>Category</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT id,name,owner_name,phone,category,status FROM businesses");

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['name']; ?></td>
    <td><?= $row['owner_name']; ?></td>
    <td><?= $row['phone']; ?></td>
    <td><?= $row['category']; ?></td>

    <td>
        <?php if($row['status']=='approved'){ ?>
            <span style="color:green;">Approved</span>
        <?php } else { ?>
            <span style="color:red;">Pending</span>
        <?php } ?>
    </td>

    <td>
        <?php if($row['status']!='approved'){ ?>
            <a href="approve_business.php?id=<?= $row['id']; ?>" class="btn approve">Approve</a>
        <?php } ?>

        <a href="delete_business.php?id=<?= $row['id']; ?>" 
           class="btn delete"
           onclick="return confirm('Delete this business?')">
           Delete
        </a>
        <?php if(isset($_SESSION['deleted'])){ ?>
<script>
alert("Business deleted successfully!");
</script>
<?php unset($_SESSION['deleted']); } ?>
    </td>
</tr>

<?php
    }
}else{
    echo "<tr><td colspan='7'>No Businesses Found</td></tr>";
}
?>

<!-- </table>
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
</form> -->

</body>
</html>
