<?php
// DO NOT call session_start() here.
// index.php (and all other pages) call session_start() BEFORE including this file.
// Using session_status() check makes it safe even if included standalone.
if(session_status() === PHP_SESSION_NONE){
    
}
// DB CHECK
$has_business = false;

if(isset($_SESSION['user_id']) && isset($conn)){
    $user_id = $_SESSION['user_id'];

    $check = mysqli_query($conn, "SELECT id FROM businesses WHERE user_id='$user_id'");
    if($check && mysqli_num_rows($check) > 0){
        $has_business = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Directory</title>
  <link rel="stylesheet" href="style1.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZPB6M0HBV8"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZPB6M0HBV8');
</script>
</head>
<body>

<nav class="navbar">
  <div class="navbar-inner">

    <div class="logo">
      <a href="index.php">
        <img src="logo3-removebg-preview (1).png" alt="Logo">
      </a>
    </div>

    <div class="menu-toggle" id="menuToggle">&#9776;</div>
    <ul class="nav-links" id="navLinks">

      <li class="dropdown">
        <a href="#">Business </a>
        <ul class="dropdown-menu">
          <li><a href="#" class="open-business">Add Business</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#">Industries </a>
        <ul class="dropdown-menu">
          <li><a href="food&amp;grocerey.php">Food &amp; Grocery</a></li>
          <li><a href="hotel&amp;restaurant.php">Hotel &amp; Restaurant</a></li>
          <li><a href="hospital.php">Hospital</a></li>
          <li><a href="education.php">Education</a></li>
          <li><a href="toys&amp;gifts.php">Toy &amp; Gift</a></li>
          <li><a href="medical.php">Medical</a></li>
          <li><a href="pestcontrol.php">Pest Control</a></li>
          <li><a href="banquet.php">Banquet</a></li>
          <li><a href="atm.php">ATM</a></li>
          <li><a href="customer.php">Customer Care Services</a></li>
          <li><a href="cateres.php">Caterers</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#">Explore Vapi </a>
        <ul class="dropdown-menu">
          <li><a href="about.php">About Vapi</a></li>
          <li><a href="gallery.php">Gallery</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#">Event  Notice </a>
        <ul class="dropdown-menu">
          <li><a href="event.php">Upcoming Events</a></li>
          <li><a href="goverment.php">Government Updates</a></li>
        </ul>
      </li>

      <li class="mobile-actions">
       <?php if($has_business): ?>

<a href="my_business.php" class="my-business-btn">
  <span class="material-icons-outlined"></span>
  My Business
</a>

<?php else: ?>

<a href="#" class="btn-outline open-business">Add Business</a>

<?php endif; ?>
        <?php if(isset($_SESSION['user_id'])): ?>
          <a href="logout.php" class="btn-outline">Logout</a>
        <?php else: ?>
          <a href="#" class="btn-outline open-signup">Sign Up</a>
        <?php endif; ?>
      </li>
    </ul>

    <div class="nav-actions">
<?php if($has_business): ?>

<a href="my_business.php" class="my-business-btn">
  <span class="material-icons-outlined"></span>
  My Business
</a>

<?php else: ?>

<a href="#" class="btn-outline open-business">Add Business</a>

<?php endif; ?>
      <?php if(isset($_SESSION['user_id'])): ?>

<div class="user-menu">
   <button class="btn-outline" id="userBtn">
    <span class="username">
        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
    </span> 
</button>

    <div class="user-dropdown" id="userDropdown">
        <a href="logout.php">Logout</a>
    </div>
</div>

<?php else: ?>

<a href="#" class="btn-outline open-signup">Sign Up</a>
<a href="#" class="switch-login">Login</a>

<?php endif; ?>
    </div>

  </div>
</nav>

<!-- ADD BUSINESS MODAL -->
<div class="modal" id="businessModal">
  <div class="modal-box" style="max-width:650px;">
    <span class="close">&times;</span>
    <section class="add-business">
      <h2>Add Your Business</h2>
      <form action="admin/add_business.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>Business Name *</label>
          <input type="text" name="name" placeholder="Enter business name" required>
        </div>
        <div class="form-group">
          <label>Owner Name</label>
          <input type="text" name="owner_name" placeholder="Owner name">
        </div>
        <div class="form-group">
          <label>Category *</label>
          <select name="category" id="category" required>
            <option value="">Select category</option>
            <option value="food">food&amp;grocerey</option>
            <option value="hotel">hotel&amp;restaurant</option>
            <option value="hospital">Hospital</option>
            <option value="education">Education</option>
            <option value="medical">medical</option>
            <option value="pest">pest control</option>
            <option value="banquet">banquet</option>
            <option value="atm">atm</option>
            <option value="customer">customer care services</option>
            <option value="caterers">caterers</option>
          </select>
        </div>
        <div class="form-group">
          <label>Subcategory *</label>
          <select name="subcategory_id" id="subcategory" required>
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
        <div class="form-group">
         <label>Phone Number *</label>
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
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label>Website</label>
          <input type="url" name="website" placeholder="https://example.com">
        </div>
        <div class="form-group">
          <label>Address *</label>
          <textarea name="address" placeholder="Full business address" required></textarea>
        </div>
        <div class="form-group">
          <label>City</label>
          <input type="text" name="city" placeholder="City">
        </div>
        <div class="form-group">
          <label>Business Description</label>
          <textarea name="description" placeholder="Describe your business"></textarea>
        </div>
        <div class="form-group">
          <label>Business Image / Logo</label>
          <input type="file" name="image">
        </div>
        <label>Business Gallery Photos</label>
        <input type="file" name="images[]" multiple>
        <button type="submit" class="btn-submit">Submit Business</button>
      </form>
    </section>
  </div>
</div>

<!-- SIGNUP MODAL -->
<div class="modal" id="signupModal">
  <div class="modal-box">
    <span class="close">&times;</span>
    <div class="signup-box">
      <h1>Sign Up</h1>
      <form method="POST" action="index.php">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="text" name="phone" placeholder="Contact Number"  maxlength="10" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="password" name="confirm_password" placeholder="Retype Password" required>
        <button type="submit" name="signup">Sign Up</button>
        <h4>Already have an account? <a href="#" class="switch-login">Login</a></h4>
      </form>
    </div>
  </div>
</div>

<!-- LOGIN MODAL -->
<div class="modal" id="loginModal">
  <div class="modal-box1">
    <span class="close">&times;</span>
    <div class="login-box">
      <h1>Login</h1>
      <form method="POST" action="index.php">
        <input type="email" name="login_email" placeholder="Enter Email" required>
        <input type="hidden" name="verify_business" value="1">
        
        <input type="password" name="login_password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button><br><br>
        <h4>Don't have an account? <a href="#" class="switch-signup">Sign Up</a></h4>
      </form>
    </div>
  </div>
</div>


  <script>
document.addEventListener("DOMContentLoaded", function () {

  // =========================
  // OPEN BUSINESS MODAL
  // =========================
  document.querySelectorAll(".open-business").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      let isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

      if (!isLoggedIn) {
        let loginModal = document.getElementById("loginModal");
        if (loginModal) loginModal.style.display = "flex";
        return;
      }

      let businessModal = document.getElementById("businessModal");
      if (businessModal) businessModal.style.display = "flex";
    });
  });

  // =========================
  // OPEN SIGNUP MODAL
  // =========================
  document.querySelectorAll(".open-signup").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      let modal = document.getElementById("signupModal");
      if (modal) modal.style.display = "flex";
    });
  });

  // =========================
  // CLOSE MODALS
  // =========================
  document.querySelectorAll(".close").forEach(function (btn) {
    btn.addEventListener("click", function () {
      let modal = btn.closest(".modal");
      if (modal) modal.style.display = "none";
    });
  });

  // =========================
  // CLICK OUTSIDE CLOSE
  // =========================
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("modal")) {
      e.target.style.display = "none";
    }
  });

  // =========================
  // SWITCH LOGIN / SIGNUP
  // =========================
  document.querySelectorAll(".switch-login").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      document.getElementById("signupModal")?.style.setProperty("display", "none");
      document.getElementById("loginModal")?.style.setProperty("display", "flex");
    });
  });

  document.querySelectorAll(".switch-signup").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      document.getElementById("loginModal")?.style.setProperty("display", "none");
      document.getElementById("signupModal")?.style.setProperty("display", "flex");
    });
  });

  // =========================
  // DROPDOWN MENU
  // =========================
  document.querySelectorAll(".dropdown > a").forEach(function (item) {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      item.parentElement.classList.toggle("active");
    });
  });

  // =========================
  // HAMBURGER MENU
  // =========================
  let toggle = document.getElementById("menuToggle");
  let nav = document.getElementById("navLinks");

  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      nav.classList.toggle("active");
    });
  }

  // =========================
  // USER DROPDOWN
  // =========================
  let userBtn = document.getElementById("userBtn");
  let userMenu = document.getElementById("userDropdown");

  if (userBtn && userMenu) {
    userBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      userMenu.style.display =
        userMenu.style.display === "block" ? "none" : "block";
    });
  }

  document.addEventListener("click", function () {
    if (userMenu) userMenu.style.display = "none";
  });

});
</script>
