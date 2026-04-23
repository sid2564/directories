<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>signup</title>
</head>
<body>
   

<div class="signup-page">
    <div class="signup-box">
        <h1>Sign Up</h1>

        <form action="/log-in" method="post">

            <input type="text" name="fullname" placeholder="Full Name" minlength="8" required>

            <input type="email" name="email" placeholder="Enter Email" required>

            <input type="text" id="contact" name="contact"       maxlength="10"
 placeholder="Contact Number" required>

            <input type="password" name="password" placeholder="Enter Password"
                   minlength="8" pattern="(?=.*[^a-zA-Z0-9]).{8,}" required>

            <input type="password" name="retype-password" placeholder="Retype Password"
                   minlength="8" pattern="(?=.*[^a-zA-Z0-9]).{8,}" required>


            <button type="submit">Sign Up</button>

            <p>Already have an account?
                <a href="login.php">Login</a>
            </p>

        </form>
    </div>
</div>


<script>
let phoneInput = document.getElementById("contact");

// sirf numbers + max 10 digits
phoneInput.addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
});

// submit ke time final check
document.querySelector("form").addEventListener("submit", function(e){
    let phone = phoneInput.value;

    if(phone.length !== 10){
        alert("Please enter exactly 10 digits number");
        e.preventDefault();
    }
});
</script>



</body>
</html>