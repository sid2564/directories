<?php
session_start();
include "db.php";
$result = mysqli_query($conn, "SELECT * FROM events ORDER BY event_date ASC");
?>
<?php include('includes/header.php'); ?>

<style>
/* ================= MODERN EVENTS PAGE ================= */

body{
    background:#f5f7fb;
    font-family: 'Segoe UI', sans-serif;
}

/* PAGE TITLE */
.events-page h1{
    text-align:center;
    padding:30px 10px 10px;
    font-size:32px;
    font-weight:700;
    color:#222;
       text-decoration: none;
    letter-spacing:0.5px;
}

/* ADD BUTTON */
.events-page button{
    transition:0.3s ease;
}

.events-page button:hover{
    transform:translateY(-2px);
    opacity:0.9;
}
.events-page a{
    text-decoration: none;
    color: inherit;
}

/* CONTAINER */
.events-container{
    width:92%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));
    gap:20px;
    padding:20px 0 40px;
}

/* CARD */
.event-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.3s ease;
    position:relative;
}

.event-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,0.12);
}

/* IMAGE */
.event-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

/* TEXT */
.event-card h3{
    font-size:18px;
    margin:12px 12px 5px;
    color:#222;
}

.event-card p{
    margin:0 12px 15px;
    color:#666;
    font-size:14px;
}

/* LINK CLEAN */
.event-card a{
    text-decoration:none;
    color:inherit;
}

/* ================= MODAL MODERN ================= */

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
    padding:15px;
    backdrop-filter:blur(4px);
}

.modal-box{
    background:#fff;
    width:500px;
    max-width:95%;
    max-height:90vh;
    overflow-y:auto;
    padding:25px;
    border-radius:16px;
    position:relative;
    animation:pop 0.25s ease;
}

/* ANIMATION */
@keyframes pop{
    from{ transform:scale(0.8); opacity:0; }
    to{ transform:scale(1); opacity:1; }
}

/* CLOSE BUTTON */
.close{
    position:absolute;
    right:15px;
    top:10px;
    font-size:26px;
    cursor:pointer;
    color:#555;
}

.close:hover{
    color:#000;
}

/* FORM */
.form-group{
    margin-bottom:15px;
}

.form-group label{
    font-weight:600;
    font-size:14px;
    color:#333;
}

.form-group input,
.form-group textarea{
    width:100%;
    padding:10px 12px;
    margin-top:6px;
    border:1px solid #ddd;
    border-radius:10px;
    outline:none;
    transition:0.2s;
    font-size:14px;
}

.form-group input:focus,
.form-group textarea:focus{
    border-color:#28a745;
    box-shadow:0 0 0 3px rgba(40,167,69,0.15);
}

/* BUTTON */
.btn-submit{
    background:linear-gradient(135deg,#28a745,#20c997);
    color:#fff;
    border:none;
    padding:12px;
    width:100%;
    cursor:pointer;
    border-radius:10px;
    font-size:15px;
    font-weight:600;
    transition:0.3s;
}

.btn-submit:hover{
    transform:translateY(-2px);
    opacity:0.95;
}

/* RESPONSIVE */
@media(max-width:768px){
    .events-page h1{
        font-size:24px;
    }

    .event-card img{
        height:160px;
    }
}
</style>

<div class="events-page">
  <h1>Upcoming Events</h1>
  <div style="text-align:center; margin-bottom:20px;">
    <button onclick="openEventModal()" 
    style="background:#28a745;color:white;padding:10px 15px;border:none;border-radius:6px;cursor:pointer;">
        + Add Event
    </button>
</div>
  <div class="events-container">
    <?php if(mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <a href="event-detai.php?id=<?php echo $row['id']; ?>">
          <div class="event-card">
            <img src="uploads/<?php echo $row['image']; ?>" alt="event">
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['event_date']; ?></p>
          </div>
        </a>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="event-card">
        <img src="imagess/event.webp" alt="event">
        <h3>Craft India Shopping Festival-2018 (Vapi)</h3>
        <p>4 Mar 2018 to 25 Mar 2018</p>
      </div>
      <div class="event-card">
        <img src="imagess/event2.jpg" alt="event">
        <h3>International Circus Festival</h3>
        <p>Sun 1 Mar 2026 to Sun 15 Mar 2026</p>
      </div>
      <div class="event-card">
        <img src="imagess/event3.jpg" alt="event">
        <h3>Fashion and Lifestyle Exhibition</h3>
        <p>20 April 2026 &bull; 10:30 AM</p>
      </div>
    <?php endif; ?>
  </div>
</div>
<!-- ================= ADD EVENT MODAL ================= -->
<div class="modal" id="eventModal">
  <div class="modal-box">

    <span class="close" onclick="closeEventModal()">&times;</span>

    <h2>Add Event</h2>

    <form action="admin/add_event.php" method="post" enctype="multipart/form-data">

        <!-- TITLE -->
        <div class="form-group">
            <label>Event Title *</label>
            <input type="text" name="title" required>
        </div>

        <!-- DATE -->
        <div class="form-group">
            <label>Event Date *</label>
            <input type="date" name="event_date" required>
        </div>

        <!-- LOCATION -->
        <div class="form-group">
            <label>Location *</label>
            <input type="text" name="location" required>
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>

        <!-- IMAGE -->
        <div class="form-group">
            <label>Event Image</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn-submit">Submit Event</button>

    </form>

  </div>
</div>

<script>
function openEventModal(){
    document.getElementById("eventModal").style.display = "flex";
}

function closeEventModal(){
    document.getElementById("eventModal").style.display = "none";
}

window.addEventListener("click", function(e){
    let modal = document.getElementById("eventModal");
    if(e.target === modal){
        closeEventModal();
    }
});
</script>
<?php include('includes/footer.php'); ?>