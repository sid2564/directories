<?php
include("../db.php");
?>
<?php include "components/sidebar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>

    <style>
        /* body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            padding:30px;
        } */

        h2{
            text-align:center;
            margin-bottom:30px;
        }

        /* table{
            width:100%;
            border-collapse: collapse;
            background:#fff;
            box-shadow:0 4px 10px rgba(0,0,0,0.1);
            border-radius:8px;
            overflow:hidden;
        } */
        
body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#f4f6f9;
}

/* table right shift */
table{
    margin-left:240px;
    margin-top:20px;
    width:calc(100% - 240px);
    border-collapse:collapse;
    table-layout:fixed;
}

th:nth-child(5),
td:nth-child(5){
    width:90px !important;
    max-width:90px !important;
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}

        th{
            background:#2c3e50;
            color:#fff;
            padding:12px;
            text-transform:uppercase;
            font-size:14px;
        }

        td{
            padding:12px;
            text-align:center;
            border-bottom:1px solid #ddd;
        }

        tr:hover{
            background:#f1f1f1;
        }

        tr:last-child td{
            border-bottom:none;
        }

        .btn-delete{
            color:#fff;
            background:red;
            padding:5px 10px;
            text-decoration:none;
            border-radius:5px;
        }
    </style>

</head>
<body>

<h2>All Registered Users</h2>

<table>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Password</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['fullname']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['phone']; ?></td>
    <td><?= $row['password']; ?></td>

    <td>
        <a href="delete_user.php?id=<?= $row['id']; ?>" 
           class="btn-delete"
           onclick="return confirm('Are you sure to delete this user?')">
           Delete
        </a>
    </td>
</tr>

<?php
    }
}else{
    echo "<tr><td colspan='6'>No Users Found</td></tr>";
}
?>

</table>

</body>
</html>