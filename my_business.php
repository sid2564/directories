<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "db.php";

/* LOGIN CHECK */
if(!isset($_SESSION['user_id'])){
    die("Session expired or not found. Please login again.");
}

$user_id = $_SESSION['user_id'];

/* BUSINESSES */
$query = "SELECT * FROM businesses WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}

/* LEADS */
$leads = mysqli_query($conn,"
SELECT l.*
FROM leads l
JOIN businesses b ON l.business_id = b.id
WHERE b.user_id = '$user_id'
ORDER BY l.id DESC
");

if(!$leads){
    die("Leads Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Business</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    font-family: Arial;
    background:#f4f4f4;
}

.container{
    width:80%;
    margin:auto;
    padding-top:20px;
}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-bottom:15px;
    padding:8px 12px;
    background:#2c3e50;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-size:14px;
}

/* CARD */
.card{
    background:#fff;
    display:flex;
    padding:15px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.card img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
}

.info{
    margin-left:20px;
    flex:1;
}

.btn-outline{
    border:1px solid #ff4d4d;
    color:#ff4d4d;
    background:none;
    padding:8px 12px;
    border-radius:5px;
    cursor:pointer;
}

/* ================= MODAL ================= */
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
    padding:10px;
}
.modal-box{
    background:#fff;
    width:650px;
    max-height:90vh;
    overflow-y:auto;
    padding:20px;
    border-radius:10px;
    position:relative;
}

.close{
    position:absolute;
    right:15px;
    top:10px;
    font-size:24px;
    cursor:pointer;
}

.form-group{
    margin-bottom:12px;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:8px;
    margin-top:5px;
}

.btn-submit{
    background:#ff4d4d;
    color:#fff;
    border:none;
    padding:10px;
    width:100%;
    cursor:pointer;
    border-radius:5px;
}
/* ================= RESPONSIVE ================= */

@media (max-width: 768px){

    .container{
        width:95%;
    }

    .modal-box{
        width:95%;
        padding:15px;
    }

    .card{
        flex-direction:column;
        align-items:flex-start;
    }

    .card img{
        width:100%;
        height:200px;
        margin-bottom:10px;
    }

    .info{
        margin-left:0;
    }

    h2{
        font-size:20px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea{
        font-size:14px;
    }

    .btn-submit{
        font-size:16px;
    }
}
</style>
</head>

<body>

<div class="container">

<a href="index.php" class="back-btn">← Back</a>

<div style="display:flex;justify-content:space-between;align-items:center;">
    <h2>My Business</h2>

    <button onclick="openBusinessModal()" 
        style="background:#ff4d4d;color:white;padding:10px 15px;border:none;border-radius:6px;cursor:pointer;">
        + Add Business
    </button>
</div>

<!-- BUSINESS LIST -->
<?php if(mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

    <div class="card">

       <?php
$img = $row['image'];

$imgPath = "uploads/" . $img;
$serverPath = __DIR__ . "/uploads/" . $img;

if(!empty($img) && file_exists($serverPath)){
    $finalImg = $imgPath;
} else {
    $finalImg = "uploads/default.png";
}
?>

<img src="<?php echo $finalImg; ?>">

        <div class="info">
            <h3><?php echo $row['name']; ?></h3>

            <p>
                <i class="fa fa-location-dot"></i>
                <?php echo $row['city'] ?? 'Location not available'; ?>
            </p>

            <a href="edit_business.php?id=<?php echo $row['id']; ?>">
                <button class="btn-outline">Edit Profile</button>
            </a>
        </div>

    </div>

    <?php } ?>

<?php } else { ?>
    <p>No business found.</p>
<?php } ?>

<!-- LEADS -->
<h2>Recent Leads</h2>


<?php if(mysqli_num_rows($leads) > 0){ ?>

    <?php while($lead = mysqli_fetch_assoc($leads)){ ?>

    <div style="background:#fff;padding:10px;margin:10px 0;border-radius:8px;">
        <p><b>Name:</b> <?php echo $lead['name']; ?></p>
        <p><b>Email:</b> <?php echo $lead['email']; ?></p>
        <p><b>Phone:</b> <?php echo $lead['phone']; ?></p>
        <p><b>Message:</b> <?php echo $lead['message']; ?></p>
    </div>

    <?php } ?>

<?php } else { ?>
    <p>No leads found.</p>
<?php } ?>

</div>

<!-- ================= MODAL ================= -->
<!-- =========================
     ADD BUSINESS MODAL (FULL)
========================= -->
<div class="modal" id="businessModal">
  <div class="modal-box">

    <span class="close">&times;</span>

    <h2>Add Your Business</h2>

    <form action="admin/add_business.php" method="post" enctype="multipart/form-data">

        <!-- BUSINESS NAME -->
        <div class="form-group">
            <label>Business Name *</label>
            <input type="text" name="name" required>
        </div>

        <!-- OWNER NAME -->
        <div class="form-group">
            <label>Owner Name</label>
            <input type="text" name="owner_name">
        </div>

        <!-- CATEGORY -->
        <div class="form-group">
            <label>Category *</label>
            <select name="category" id="category" required>
                <option value="">Select Category</option>
                <option value="food">Food & Grocery</option>
                <option value="hotel">Hotel & Restaurant</option>
                <option value="hospital">Hospital</option>
                <option value="education">Education</option>
                <option value="medical">Medical</option>
                <option value="pest">Pest Control</option>
                <option value="banquet">Banquet</option>
                <option value="atm">ATM / Bank</option>
                <option value="customer">Customer Care</option>
                <option value="caterers">Caterers</option>
            </select>
        </div>

        <!-- SUBCATEGORY -->
        <div class="form-group">
            <label>Sub Category *</label>
            <select name="subcategory" id="subcategory" required>
                <option value="">Select Sub Category</option>

                <option value="">Select Subcategory</option>
            <option value="1" data-category="food">Pizza</option>
            <option value="2" data-category="food">Burger</option>
            <option value="3" data-category="food">Momo</option>
            <option value="4" data-category="food">Grocery</option>
            <option value="5" data-category="food">Fruits</option>
            <option value="6" data-category="food">Coffee</option>
            <option value="7" data-category="food">Chinese</option>
            <option value="8" data-category="food">Bakery</option>
            <option value="9" data-category="food">Dairy</option>
            <option value="10" data-category="hotel">Hotel</option>
            <option value="11" data-category="hotel">Guest House</option>
            <option value="12" data-category="hotel">Restaurant</option>
            <option value="13" data-category="hotel">Veg Restaurant</option>
            <option value="14" data-category="hotel">Non-Veg Restaurant</option>
            <option value="15" data-category="hotel">South Indian Restaurant</option>
            <option value="16" data-category="hotel">Gujarati Restaurant</option>
            <option value="17" data-category="hotel">Punjabi Restaurant</option>
            <option value="18" data-category="hotel">Marathi Restaurant</option>
            <option value="19" data-category="hospital">Dental Hospital</option>
            <option value="20" data-category="hospital">Eye Hospital</option>
            <option value="21" data-category="hospital">Children Hospital</option>
            <option value="22" data-category="hospital">Public Hospital</option>
            <option value="23" data-category="hospital">Skin &amp; Hair Hospital</option>
            <option value="24" data-category="hospital">Homeopathic Hospital</option>
            <option value="25" data-category="hospital">Ayurvedic Hospital</option>
            <option value="26" data-category="hospital">Multispeciality Hospital</option>
            <option value="27" data-category="hospital">Veterinary Hospital</option>
            <option value="28" data-category="education">College</option>
            <option value="29" data-category="education">School</option>
            <option value="30" data-category="education">Training Institute</option>
            <option value="31" data-category="education">Coaching Class</option>
            <option value="32" data-category="education">Play School</option>
            <option value="33" data-category="education">Language School</option>
            <option value="34" data-category="education">Painting School</option>
            <option value="35" data-category="education">Library</option>
            <option value="36" data-category="education">Computer Class</option>
            <option value="37" data-category="toys">Toy Shop</option>
            <option value="38" data-category="toys">Flower Shop</option>
            <option value="39" data-category="toys">Handicraft Shop</option>
            <option value="40" data-category="toys">Art Gallery</option>
            <option value="41" data-category="toys">Gift Shop</option>
            <option value="42" data-category="medical">Chemist Store</option>
            <option value="43" data-category="medical">Ayurvedic Medicine Store</option>
            <option value="44" data-category="medical">24 Hr Chemist</option>
            <option value="45" data-category="medical">Generic Medical Store</option>
            <option value="46" data-category="pest">Pest Control Services</option>
            <option value="47" data-category="pest">Pest Control for Cockroach</option>
            <option value="48" data-category="pest">Pest Control for Mosquito</option>
            <option value="49" data-category="pest">Pest Control for Rat</option>
            <option value="50" data-category="pest">Pest Control for Ant</option>
            <option value="51" data-category="banquet">Banquet Hall</option>
            <option value="52" data-category="banquet">Marriage Hall</option>
            <option value="53" data-category="banquet">Party Plot</option>
            <option value="54" data-category="atm">HDFC Bank ATM</option>
            <option value="55" data-category="atm">State Bank of India ATM</option>
            <option value="56" data-category="atm">Indian Bank</option>
            <option value="57" data-category="atm">ICICI Bank</option>
            <option value="58" data-category="atm">Bank of Baroda</option>
            <option value="59" data-category="atm">Punjab National Bank</option>
            <option value="60" data-category="atm">OBC Bank</option>
            <option value="61" data-category="customer">Customer Care Service</option>
            <option value="62" data-category="customer">Service Center</option>
            <option value="63" data-category="customer">Technical Support</option>
            <option value="64" data-category="customer">Complaints</option>
            <option value="65" data-category="cateres">Party Caterers</option>
            <option value="66" data-category="cateres">Wedding Caterers</option>
            <option value="67" data-category="cateres">House Party</option>
            <option value="68" data-category="cateres">Festival / Special Events</option>

            </select>
        </div>

        <!-- PHONE -->
        <div class="form-group">
            <label>Phone *</label>
             <input 
            type="tel"
            name="phone"
            maxlength="10"
            inputmode="numeric"
            pattern="[0-9]{10}"
            placeholder="Enter phone number"
            oninput="this.value = this.value.replace(/[^0-9]/g,'')"
            required
          >
        </div>

        <!-- EMAIL -->
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <!-- WEBSITE -->
        <div class="form-group">
            <label>Website</label>
            <input type="url" name="website" placeholder="https://example.com">
        </div>

        <!-- ADDRESS -->
        <div class="form-group">
            <label>Address *</label>
            <textarea name="address" required></textarea>
        </div>

        <!-- CITY -->
        <div class="form-group">
            <label>City*</label>
            <input type="text" name="city">
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group">
            <label>Business Description</label>
            <textarea name="description" placeholder="Write about your business"></textarea>
        </div>

        <!-- LOGO IMAGE -->
        <div class="form-group">
            <label>Business Logo / Image *</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <!-- GALLERY IMAGES -->
        <div class="form-group">
            <label>Gallery Images</label>
            <input type="file" name="images[]" multiple accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Submit Business</button>

    </form>

  </div>
</div>

<!-- ================= JS ================= -->
<script>
function openBusinessModal(){
    document.getElementById("businessModal").style.display = "flex";
}

function closeBusinessModal(){
    document.getElementById("businessModal").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function(){

    document.querySelector(".close").onclick = closeBusinessModal;

    window.onclick = function(e){
        let modal = document.getElementById("businessModal");
        if(e.target === modal){
            closeBusinessModal();
        }
    };

});
</script>
<script>
document.getElementById("category").addEventListener("change", function(){
    let cat = this.value;
    let options = document.querySelectorAll("#subcategory option");

    options.forEach(opt => {
        if(!opt.dataset.category){
            opt.style.display = "block";
        } else {
            opt.style.display = (opt.dataset.category === cat) ? "block" : "none";
        }
    });

    document.getElementById("subcategory").value = "";
});
</script>
</body>
</html>
