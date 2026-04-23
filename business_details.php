<?php
session_start();
include "db.php";


$business_id = $_GET['id'] ?? 0;

$user_id = $_SESSION['user_id'] ?? null;
$name = $_SESSION['user_name'] ?? '';
$email = $_SESSION['user_email'] ?? '';
$phone = $_SESSION['user_phone'] ?? '';
$message = "User viewed business";
if($business_id && $user_id){

    if(!isset($_SESSION['lead_'.$business_id])){

        mysqli_query($conn,"
            INSERT INTO leads 
            (business_id, name, phone, email, message)
            VALUES 
            ('$business_id', '$name', '$phone', '$email', '$message')
        ");

        $_SESSION['lead_'.$business_id] = true;
    }
}
// Handle lead submission
if(isset($_POST['submit_lead'])){
    $business_id = (int)$_POST['business_id'];
    $name    = mysqli_real_escape_string($conn, $_POST['lead_name']);
    $email   = mysqli_real_escape_string($conn, $_POST['lead_email']);
    $phone   = mysqli_real_escape_string($conn, $_POST['lead_phone']);
    $message = mysqli_real_escape_string($conn, $_POST['lead_message']);
    mysqli_query($conn, "INSERT INTO leads (business_id, name, email, phone, message) VALUES ('$business_id','$name','$email','$phone','$message')");
    $leadSuccess = "Your enquiry has been sent successfully!";
}

$id  = $_GET['id'];
$sql = "SELECT * FROM businesses WHERE id='$id'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>
<?php include('includes/header.php'); ?>

<style>
.biz-detail-wrap { max-width:1100px; margin:35px auto; padding:0 20px; }
.biz-top { background:#fff; border-radius:14px; padding:28px; box-shadow:0 4px 18px rgba(0,0,0,0.08); display:flex; gap:28px; flex-wrap:wrap; margin-bottom:24px; }
.biz-top img { width:360px; height:240px; object-fit:cover; border-radius:10px; flex-shrink:0; }
.biz-info h1 { margin:0 0 10px; font-size:1.6rem; color:#1e293b; }
.biz-info p  { color:#475569; margin:5px 0; }
.biz-info .badge { display:inline-block; background:#dcfce7; color:#16a34a; padding:3px 12px; border-radius:20px; font-size:0.8rem; font-weight:600; margin-bottom:10px; }
.biz-btns { display:flex; gap:10px; flex-wrap:wrap; margin-top:14px; }
.biz-btn { padding:10px 20px; border-radius:8px; text-decoration:none; color:white; border:none; cursor:pointer; font-size:0.9rem; font-weight:600; }
.btn-call { background:#16a34a; } .btn-wa { background:#25D366; } .btn-web { background:#2563eb; }
.phone-reveal { margin-top:10px; font-size:1.1rem; color:#1e293b; font-weight:600; display:none; }

.section-box { background:#fff; border-radius:14px; padding:28px; box-shadow:0 4px 18px rgba(0,0,0,0.08); margin-bottom:24px; }
.section-box h2 { margin:0 0 20px; font-size:1.2rem; color:#1e293b; border-left:4px solid #ef4444; padding-left:12px; }

.gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:14px; }
.gallery-grid img { width:100%; height:150px; object-fit:cover; border-radius:8px; cursor:pointer; transition:0.3s; }
.gallery-grid img:hover { transform:scale(1.04); }

/* Lead Form */
.lead-form { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.lead-form .full { grid-column:1/-1; }
.lead-form input, .lead-form textarea {
  width:100%; padding:11px 14px; border:1.5px solid #e2e8f0;
  border-radius:8px; font-size:0.92rem; font-family:inherit;
  background:#f8fafc; transition:0.2s; outline:none;
}
.lead-form input:focus, .lead-form textarea:focus { border-color:#ef4444; background:#fff; box-shadow:0 0 0 3px rgba(239,68,68,0.1); }
.lead-form textarea { resize:vertical; min-height:100px; }
.btn-lead { background:linear-gradient(135deg,#ef4444,#dc2626); color:white; border:none; padding:13px 30px; border-radius:8px; font-size:1rem; font-weight:600; cursor:pointer; transition:0.3s; }
.btn-lead:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(239,68,68,0.35); }
.success-msg { background:#dcfce7; border:1px solid #86efac; color:#166534; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-weight:500; }

/* Reviews */
.review-item { border:1px solid #e5e7eb; padding:16px; border-radius:10px; margin-bottom:12px; }
.review-item strong { color:#1e293b; }
.stars { color:#f59e0b; margin:4px 0; }
.review-form input, .review-form select, .review-form textarea {
  width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px;
  font-size:0.92rem; font-family:inherit; margin-bottom:12px; background:#f8fafc; outline:none;
}
.review-form input:focus, .review-form select:focus, .review-form textarea:focus { border-color:#2563eb; }
.btn-review { background:#2563eb; color:white; border:none; padding:11px 26px; border-radius:8px; font-weight:600; cursor:pointer; }

/* Upload modal */
.modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:9999; }
.modal.open { display:flex; }
.modal-box { background:#fff; padding:32px; border-radius:14px; width:380px; position:relative; }
.modal-box .close-btn { position:absolute; right:16px; top:12px; font-size:1.4rem; cursor:pointer; color:#94a3b8; }
.modal-box h3 { margin:0 0 20px; }

.star-rating {
  font-size: 26px;
  cursor: pointer;
  color: #000000;
  margin-bottom: 10px;
}

.star-rating .star {
  transition: 0.2s;
}

.star-rating .star.active {
  color: #f59e0b;
}

.reviews-list{
  display: block;
  text-align: left;
}

/* REVIEW CARD LEFT ALIGN */
.review-card{
  width: 100%;
  max-width: 700px;

  margin: 10px 0;   /* ❌ no auto center */
  
  background: #fff;
  padding: 15px;
  border-radius: 10px;
  border: 1px solid #000;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);

  text-align: left;
}

/* optional: stars alignment */
.stars{
  text-align: left;
}
</style>

<div class="biz-detail-wrap">

  <!-- Business Header -->
  <div class="biz-top">
    <?php if(!empty($row['image'])): ?>
      <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
    <?php else: ?>
      <img src="imagess/car1.jpg" alt="placeholder">
    <?php endif; ?>
    <div class="biz-info">
      <span class="badge">✅ <?php echo ucfirst($row['status']); ?></span>
      <h1><?php echo $row['name']; ?></h1>
      <p>📂 <strong>Category:</strong> <?php echo ucfirst($row['category']); ?></p>
      <?php if($row['owner_name']): ?><p>👤 <strong>Owner:</strong> <?php echo $row['owner_name']; ?></p><?php endif; ?>
      <?php if($row['email']): ?><p>✉️ <strong>Email:</strong> <?php echo $row['email']; ?></p><?php endif; ?>
      <?php if($row['address']): ?><p>📍 <strong>Address:</strong> <?php echo $row['address']; ?></p><?php endif; ?>
      <?php if($row['description']): ?><p style="margin-top:10px;"><?php echo $row['description']; ?></p><?php endif; ?>
      <div class="biz-btns">
        <button class="biz-btn btn-call" onclick="togglePhone()">📞 Show Number</button>
        <?php if(!empty($row['phone'])): ?>
          <a href="https://wa.me/<?php echo preg_replace('/\D/','',$row['phone']); ?>" class="biz-btn btn-wa" target="_blank">💬 WhatsApp</a>
        <?php endif; ?>
        <?php if(!empty($row['website'])): ?>
          <a href="<?php echo $row['website']; ?>" class="biz-btn btn-web" target="_blank">🌐 Website</a>
        <?php endif; ?>
      </div>
      <p class="phone-reveal" id="phoneReveal">📞 <?php echo $row['phone']; ?></p>
    </div>
  </div>

  <!-- Gallery -->
  <?php
  $imgs = mysqli_query($conn,"SELECT * FROM business_images WHERE business_id='$id'");
  if(mysqli_num_rows($imgs) > 0):
  ?>
  <div class="section-box">
    <h2>📸 Photos</h2>
    <div class="gallery-grid">
      <?php while($img = mysqli_fetch_assoc($imgs)): ?>
        <img src="uploads/<?php echo $img['image']; ?>" alt="photo">
      <?php endwhile; ?>
    </div>
    <br>
    <button class="biz-btn btn-web" onclick="document.getElementById('imgModal').classList.add('open')">+ Add Photos</button>
  </div>
  <?php endif; ?>

  <!-- ====== LEAD / ENQUIRY FORM ====== -->
  <div class="section-box">
    <h2>📩 Send Enquiry</h2>
    <?php if(!empty($leadSuccess)): ?>
      <div class="success-msg">✅ <?php echo $leadSuccess; ?></div>
    <?php endif; ?>
    <form method="POST" class="lead-form">
      <input type="hidden" name="business_id" value="<?php echo $id; ?>">
      <div>
        <input type="text" name="lead_name" placeholder="Your Full Name" required>
      </div>
      <div>
        <input type="tel" name="lead_phone" placeholder="Your Phone Number" required>
      </div>
      <div>
        <input type="email" name="lead_email" placeholder="Your Email (optional)">
      </div>
      <div class="full">
        <textarea name="lead_message" placeholder="Write your message or enquiry here..."></textarea>
      </div>
      <div class="full">
        <button type="submit" name="submit_lead" class="btn-lead">Send Enquiry 🚀</button>
      </div>
    </form>
  </div>

  <!-- Reviews -->
 <div class="section-box">
  <h2>⭐ Leave a Review</h2>

  <?php if(!isset($_SESSION['user_id'])): ?>

    <p style="color:red;">⚠️ Please login to submit review</p>

  <?php else: ?>

    <form method="POST" action="add_review.php" class="review-form">

      <input type="hidden" name="business_id" value="<?php echo $id; ?>">
      <input type="hidden" name="name" value="<?php echo $_SESSION['user_name']; ?>">

      <!-- ⭐ STAR RATING -->
      <div class="star-rating">
        <input type="hidden" name="rating" id="ratingValue" required>
        <span class="star" data-value="1">☆</span>
        <span class="star" data-value="2">☆</span>
        <span class="star" data-value="3">☆</span>
        <span class="star" data-value="4">☆</span>
        <span class="star" data-value="5">☆</span>
      </div>

      <textarea name="comment" placeholder="Write your review..." required></textarea>

      <button type="submit" class="btn-review">Submit Review</button>
    </form>

  <?php endif; ?>
</div>

  <!-- Customer Reviews -->
  <div class="section-box">
  <h2>💬 Customer Reviews</h2>

  <div class="reviews-list">

    <?php
    $reviews = mysqli_query($conn,"SELECT * FROM reviews WHERE business_id='$id' ORDER BY id DESC");
    while($r = mysqli_fetch_assoc($reviews)):
    ?>

    <div class="review-card">
      <strong><?php echo $r['name']; ?></strong>

      <div class="stars">
        <?php for($i=1;$i<=5;$i++) echo $i<=$r['rating']?"⭐":"☆"; ?>
      </div>

      <p><?php echo $r['comment']; ?></p>
    </div>

    <?php endwhile; ?>

  </div>
</div>

</div>

<!-- Image Upload Modal -->
<div class="modal" id="imgModal">
  <div class="modal-box">
    <span class="close-btn" onclick="document.getElementById('imgModal').classList.remove('open')">✕</span>
    <h3>Upload Photo</h3>
    <form method="post" action="upload_image.php" enctype="multipart/form-data">
      <input type="hidden" name="business_id" value="<?php echo $row['id']; ?>">
      <input type="file" name="image" required style="margin-bottom:14px;">
      <button type="submit" class="btn-lead" style="width:100%;">Upload</button>
    </form>
  </div>
</div>

<script>
function togglePhone(){
  var p = document.getElementById("phoneReveal");
  p.style.display = p.style.display === "block" ? "none" : "block";
}
window.onclick = function(e){
  if(e.target.classList.contains('modal')) e.target.classList.remove('open');
}
</script>
<script>
document.querySelectorAll(".star-rating .star").forEach(function(star){
    star.addEventListener("click", function(){
        let rating = this.getAttribute("data-value");
        document.getElementById("ratingValue").value = rating;

        document.querySelectorAll(".star-rating .star").forEach(function(s){
            s.classList.remove("active");
        });

        for(let i=0; i<rating; i++){
            document.querySelectorAll(".star-rating .star")[i].classList.add("active");
        }
    });
});
</script>
<?php include('includes/footer.php'); ?>