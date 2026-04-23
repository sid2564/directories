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
    $query    = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result   = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['fullname'];
        $_SESSION['user_email'] = $user['email'];
        header("Location: index.php"); // safe - no HTML output yet
        exit();
    } else {
        $loginError = "Invalid Email or Password";
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
        $q = "INSERT INTO users (fullname, email, phone, password) VALUES ('$fullname','$email','$phone','$password')";
        if(mysqli_query($conn, $q)){
            $signupSuccess = "Signup Successful! Please login.";
        } else {
            $signupError = "Error: " . mysqli_error($conn);
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

<!-- HERO -->
<section class="hero">
  <div class="hero-overlay">
    <h1>Discover &amp; Connect: Your Ultimate Directory Hub</h1>
    <div class="search-box">
      <input type="text" placeholder="what are you looking for?">
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
      <input type="text" placeholder="location">
      <button class="btn-search">search</button>
    </div>
  </div>
</section>

<div class="categories">
  <h2>browse by category</h2><br><br>
  <p>Explore businesses across various industries and find exactly what you need</p>
  <div class="dicv">
    <section class="category">
      <img src="imagess/car1.jpg" alt="card">
      <div class="con2"><h4><a href="food&amp;grocerey.php" class="category-link">food &amp; grocery</a></h4></div>
    </section>
    <section class="category">
      <img src="imagess/car2.jpg" alt="card" height="170" width="300">
      <div class="con2"><h4><a href="hotel&amp;restaurant.php" class="category-link">hotel &amp; restaurant</a></h4></div>
    </section>
    <section class="category">
      <img src="imagess/car3.jpg" alt="card" height="170" width="300">
      <div class="con2"><h4><a href="toys&amp;gifts.php" class="category-link">toys &amp; gifts</a></h4></div>
    </section>
  </div>
  <div>
    <div class="dicv1">
      <section class="category">
        <img src="imagess/car4.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="hospital.php" class="category-link">hospital</a></h4></div>
      </section>
      <section class="category">
        <img src="imagess/car5.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="medical.php" class="category-link">medical</a></h4></div>
      </section>
      <section class="category">
        <img src="imagess/car6.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="education.php" class="category-link">education</a></h4></div>
      </section>
    </div>
    <div class="dicv2">
      <section class="category">
        <img src="imagess/car7.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="pestcontrol.php" class="category-link">pest control</a></h4></div>
      </section>
      <section class="category">
        <img src="imagess/car8.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="banquet.php" class="category-link">banquet</a></h4></div>
      </section>
      <section class="category">
        <img src="imagess/car9.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="atm.php" class="category-link">atm</a></h4></div>
      </section>
    </div>
    <div class="dicv3">
      <section class="category">
        <img src="imagess/car10.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="customer.php" class="category-link">customer care services</a></h4></div>
      </section>
      <section class="category">
        <img src="imagess/car11.jpg" alt="card" height="170" width="300">
        <div class="con2"><h4><a href="cateres.php" class="category-link">cateres</a></h4></div>
      </section>
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

<section class="reviews">
  <h2>What People Say</h2>
  <div class="reviews-grid">
    <div class="review-card">
      <p class="review-text">"Very helpful platform. I found a reliable service provider within minutes."</p>
      <div class="reviewer"><strong>Rahul Patel</strong><span>&#11088;&#11088;&#11088;&#11088;&#11088;</span></div>
    </div>
    <div class="review-card">
      <p class="review-text">"Easy to use and businesses listed are genuine. Highly recommended!"</p>
      <div class="reviewer"><strong>Anjali Sharma</strong><span>&#11088;&#11088;&#11088;&#11088;</span></div>
    </div>
    <div class="review-card">
      <p class="review-text">"Best local business directory for Vapi. Clean design and fast search."</p>
      <div class="reviewer"><strong>Mohit Desai</strong><span>&#11088;&#11088;&#11088;&#11088;&#11088;</span></div>
    </div>
  </div>
</section>

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
<script>
  // PHP session value passed to JS
  var userIsLoggedIn = <?php echo $isLoggedIn; ?>;

  document.addEventListener("DOMContentLoaded", function () {
    var modal    = document.getElementById("loginModal");
    var closeBtn = document.querySelector("#loginModal .close");

    function openLoginModal()  { if (modal) modal.style.display = "flex"; }
    function closeLoginModal() { if (modal) modal.style.display = "none"; }

    if (closeBtn) closeBtn.onclick = closeLoginModal;

    // Show popup after 10 seconds ONLY for guests (not logged in)
    if (!userIsLoggedIn) {
      setTimeout(openLoginModal, 10000);
    }

    // Category links: allow if logged in, block + show popup if not
    document.querySelectorAll(".category-link").forEach(function (link) {
      link.addEventListener("click", function (e) {
        if (!userIsLoggedIn) {
          e.preventDefault();
          openLoginModal();
        }
      });
    });
  });
</script>

<!-- FAQ accordion -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".faq-item").forEach(function (item) {
    item.addEventListener("click", function () {
      var answer = item.querySelector(".faq-answer");
      document.querySelectorAll(".faq-answer").forEach(function (a) {
        if (a !== answer) a.style.display = "none";
      });
      answer.style.display = answer.style.display === "block" ? "none" : "block";
    });
  });
});
</script>

<?php include('includes/footer.php'); ?>
