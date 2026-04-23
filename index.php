<?php
// ===================================================
// ALL PHP LOGIC FIRST - before ANY HTML output
// ===================================================
session_start();
include "db.php";

// --- HANDLE LOGIN ---
if(isset($_POST['login'])){

    $email    = $_POST['login_email'];
    $password = $_POST['login_password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);

        if($user['password'] == $password){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: index.php");
            exit;
        }
    }
}

// --- HANDLE SIGNUP ---
if(isset($_POST['signup'])){

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if($password != $confirm){
        $signupError = "Passwords do not match";
    } else {

        $q = "INSERT INTO users (fullname, email, phone, password)
              VALUES ('$fullname','$email','$phone','$password')";

        if(mysqli_query($conn, $q)){

            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['user_name'] = $fullname;
            $_SESSION['user_email'] = $email;

            header("Location: index.php");
            exit;

        } else {
            $signupError = mysqli_error($conn);
        }
    }
}
// --- HANDLE ADD BUSINESS ---
if(isset($_POST['add_business'])){
    $name      = $_POST['name'] ?? '';
    $owner     = $_POST['owner_name'] ?? '';
    $category  = $_POST['category'] ?? '';
    $subcat    = $_POST['subcategory'] ?? '';
    $phone     = $_POST['phone'] ?? '';
    $email     = $_POST['email'] ?? '';
    $address   = $_POST['address'] ?? '';
    $sql = "INSERT INTO businesses (name,owner_name,category,subcategory_id,phone,email,address)
            VALUES ('$name','$owner','$category','$subcat','$phone','$email','$address')";
    mysqli_query($conn, $sql);
}

// Tell JS if user is logged in - must be set before HTML output
$isLoggedIn = isset($_SESSION['user_id']) ? 'true' : 'false';

// ===================================================
// HTML OUTPUT STARTS HERE
// ===================================================
?>
<?php include('includes/header.php'); ?>

<?php if(!empty($loginError)): ?>
  <script>alert('<?php echo addslashes($loginError); ?>');</script>
<?php endif; ?>
<?php if(!empty($signupError)): ?>
  <script>alert('<?php echo addslashes($signupError); ?>');</script>
<?php endif; ?>
<?php if(!empty($signupSuccess)): ?>
  <script>alert('<?php echo addslashes($signupSuccess); ?>');</script>
<?php endif; ?>
<?php if(isset($_GET['added'])): ?>
<script>
alert("Business successfully added!");
</script>
<?php endif; ?>
<!-- HERO -->
<section class="hero">
  <div class="hero-overlay">
    <h1>Discover &amp; Connect: Your Ultimate Directory Hub</h1>
   <form class="search-box" method="GET" action="search.php">
      <input type="text" name="q" placeholder="what are you looking for?">
      <select required>
        <option value="">Select category</option>
        <option>food&amp;grocerey</option>
        <option>hotel&amp;restaurant</option>
        <option>Hospital</option>
        <option>Education</option>
        <option>medical</option>
        <option>pest control</option>
        <option>banquet</option>
        <option>atm</option>
        <option>customer care services</option>
        <option>caterers</option>
      </select>
      <input type="text" name="city" placeholder="location">
      <button type="submit" class="btn-search">search</button>
    </form>
  </div>
</section>

<div class="categories">
  <h2>browse by category</h2><br><br>
  <p>Explore businesses across various industries and find exactly what you need</p>

  <div class="dicv">

    <a href="food&grocerey.php" class="category-box">
      <section class="category">
        <img src="imagess/car1.jpg" alt="card">
        <div class="con2"><h4>food & grocery</h4></div>
      </section>
    </a>

    <a href="hotel&restaurant.php" class="category-box">
      <section class="category">
        <img src="imagess/car2.jpg" alt="card">
        <div class="con2"><h4>hotel & restaurant</h4></div>
      </section>
    </a>

    <a href="toys&gifts.php" class="category-box">
      <section class="category">
        <img src="imagess/car3.jpg" alt="card">
        <div class="con2"><h4>toys & gifts</h4></div>
      </section>
    </a>

  </div>

  <div>

    <div class="dicv1">

      <a href="hospital.php" class="category-box">
        <section class="category">
          <img src="imagess/car4.jpg" alt="card">
          <div class="con2"><h4>hospital</h4></div>
        </section>
      </a>

      <a href="medical.php" class="category-box">
        <section class="category">
          <img src="imagess/car5.jpg" alt="card">
          <div class="con2"><h4>medical</h4></div>
        </section>
      </a>

      <a href="education.php" class="category-box">
        <section class="category">
          <img src="imagess/car6.jpg" alt="card">
          <div class="con2"><h4>education</h4></div>
        </section>
      </a>

    </div>

    <div class="dicv2">

      <a href="pestcontrol.php" class="category-box">
        <section class="category">
          <img src="imagess/car7.jpg" alt="card">
          <div class="con2"><h4>pest control</h4></div>
        </section>
      </a>

      <a href="banquet.php" class="category-box">
        <section class="category">
          <img src="imagess/car8.jpg" alt="card">
          <div class="con2"><h4>banquet</h4></div>
        </section>
      </a>

      <a href="atm.php" class="category-box">
        <section class="category">
          <img src="imagess/car9.jpg" alt="card">
          <div class="con2"><h4>atm</h4></div>
        </section>
      </a>

    </div>

    <div class="dicv3">

      <a href="customer.php" class="category-box">
        <section class="category">
          <img src="imagess/car10.jpg" alt="card">
          <div class="con2"><h4>customer care services</h4></div>
        </section>
      </a>

      <a href="cateres.php" class="category-box">
        <section class="category">
          <img src="imagess/car11.jpg" alt="card">
          <div class="con2"><h4>cateres</h4></div>
        </section>
      </a>

    </div>

  </div>
</div>

<section class="why-us">
  <h2>Why Choose us ??</h2>
  <div class="why-grid">
    <div class="why-card">
      <span class="material-icons-outlined">verified</span>
      <h3>Verified Listings</h3><br><br>
      <p>Every business is checked before being listed.</p>
    </div>
    <div class="why-card">
      <span class="material-icons-outlined">beenhere</span>
      <h3>Trusted Businesses</h3><br><br>
      <p>Find genuine and reliable local services.</p>
    </div>
    <div class="why-card">
      <span class="material-icons-outlined">group</span>
      <h3>Real Reviews</h3><br><br>
      <p>Genuine reviews from real customers you can trust.</p>
    </div>
    <div class="why-card">
      <span class="material-icons-outlined">timer</span>
      <h3>Always Updated</h3><br><br>
      <p>Business info is regularly updated for accuracy.</p>
    </div>
  </div>
</section>

<?php include('includes/reviews-section.php'); ?>

<section class="how-it-works">
  <h2>How It Works</h2>
  <div class="steps">
    <div class="step-card">
      <div class="step-number">1</div>
      <h3>Search Business</h3><br><br>
      <p>Search for businesses by name, category, or location.</p>
    </div>
    <div class="step-card">
      <div class="step-number">2</div>
      <h3>Compare Options</h3><br><br>
      <p>View details, ratings, and services offered by businesses.</p>
    </div>
    <div class="step-card">
      <div class="step-number">3</div>
      <h3>Contact Directly</h3><br><br>
      <p>Call or visit the business directly using provided information.</p>
    </div>
    <div class="step-card">
      <div class="step-number">4</div>
      <h3>Post Your Business</h3><br><br>
      <p>Add your business and reach more local customers easily.</p>
    </div>
  </div>
</section>

<section class="faq-section">
  <h2>Frequently Asked Questions</h2>
  <div class="faq-item">
    <div class="faq-question">How can I add my business?</div>
    <div class="faq-answer">Click the "Add Business" button and fill in the required details.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">Is registration free?</div>
    <div class="faq-answer">Yes, basic registration is completely free for all users.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">How do I update my business details?</div>
    <div class="faq-answer">After login, go to your dashboard and edit your business information.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">How long does it take for my business to appear on the website?</div>
    <div class="faq-answer">Once submitted, it may take a short verification time before going live.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">Can customers leave reviews?</div>
    <div class="faq-answer">Yes, customers can share feedback and reviews to help other users.</div>
  </div>
  <div class="faq-item">
    <div class="faq-question">Why should I list my business in directories?</div>
    <div class="faq-answer">Listings boost local search visibility, credibility, and drive traffic to your website.</div>
  </div>
</section>

<!-- LOGIN POPUP SCRIPT -->
========================= -->
<script>
var userIsLoggedIn = <?php echo $isLoggedIn; ?>;

document.addEventListener("DOMContentLoaded", function(){

    var modal = document.getElementById("loginModal");

    function openLogin(){
        if(modal) modal.style.display = "flex";
    }

    if(!userIsLoggedIn){
        setTimeout(openLogin, 10000);
    }

});
</script>

<?php if(isset($_SESSION['open_business_modal'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function(){
    var modal = document.getElementById("businessModal");
    if(modal){
        modal.style.display = "flex";
    }
});
</script>
<?php unset($_SESSION['open_business_modal']); ?>
<?php endif; ?>

<?php include('includes/footer.php'); ?>
<?php include('includes/footer.php'); ?>
