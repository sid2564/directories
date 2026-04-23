<?php
session_start();
?>
<?php include('includes/header.php'); ?>

<style>
.gallery-page { background-color:#b4c1ce; min-height:60vh; padding-bottom:40px; }
.gallery-page h1 { text-align:center; padding:30px 0; }
.gallery-container { width:90%; margin:auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px; padding-bottom:40px; }
.gallery-item { overflow:hidden; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); background:#fff; }
.gallery-item img { width:100%; height:250px; object-fit:cover; transition:0.4s ease; }
.gallery-item:hover img { transform:scale(1.1); }
</style>

<div class="gallery-page">
  <h1>Vapi Gallery</h1>
  <div class="gallery-container">
    <div class="gallery-item"><img src="imagess/vapi1.jpg" alt="Vapi"></div>
    <div class="gallery-item"><img src="imagess/vapi2.jpg" alt="Vapi"></div>
    <div class="gallery-item"><img src="imagess/vapi3.webp" alt="Vapi"></div>
    <div class="gallery-item"><img src="imagess/vapi4.jpg" alt="Vapi"></div>
    <div class="gallery-item"><img src="imagess/vapi5.jpg" alt="Vapi"></div>
    <div class="gallery-item"><img src="imagess/vapi6.jpg" alt="Vapi"></div>
  </div>
</div>

<?php include('includes/footer.php'); ?>