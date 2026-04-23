<?php
include "db.php";

/* DEBUG CHECK */
if(!$conn){
    die("DB NOT CONNECTED");
}

/* FETCH ONCE */
$result = mysqli_query($conn, "
    SELECT * FROM reviews 
    ORDER BY id DESC
    LIMIT 10
");

$reviews = [];

if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $reviews[] = $row;
    }
}
?>

<section class="reviews">

<h2 style="text-align:center; margin-bottom:15px;">What People Say</h2>

<style>
.reviews-wrapper{
  overflow: hidden;
  width: 100%;
  background: #f5f5f5;
  padding: 10px 0;
}

.reviews-slider{
  display: flex;
  gap: 15px;
  width: max-content;
  animation: scrollReviews 25s linear infinite;
}

.review-card{
  width: 260px;
  height: 160px;
  background: #fff;
  padding: 15px;
  border-radius: 12px;
  border: 1px solid #000;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  font-family: Arial;

  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;

  flex-shrink: 0;
}

.review-text{
  font-size: 14px;
  color: #000;
  font-weight: 500;

  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.reviewer strong{
  display: block;
  margin-bottom: 5px;
}

@keyframes scrollReviews {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

.reviews-wrapper:hover .reviews-slider{
  animation-play-state: paused;
}
</style>

<div class="reviews-wrapper">
  <div class="reviews-slider">

    <!-- LOOP 1 -->
    <?php foreach($reviews as $r): ?>
      <div class="review-card">

        <p class="review-text">
          "<?php echo $r['comment'] ?? 'No review'; ?>"
        </p>

        <div class="reviewer">
          <strong><?php echo $r['name'] ?? 'Anonymous'; ?></strong>

          <span>
            <?php 
            for($i=1; $i<=5; $i++){
                echo $i <= $r['rating'] ? "⭐" : "☆";
            }
            ?>
          </span>
        </div>

      </div>
    <?php endforeach; ?>

    <!-- LOOP 2 (DUPLICATE FOR SMOOTH SCROLL) -->
    <?php foreach($reviews as $r): ?>
      <div class="review-card">

        <p class="review-text">
          "<?php echo $r['comment'] ?? 'No review'; ?>"
        </p>

        <div class="reviewer">
          <strong><?php echo $r['name'] ?? 'Anonymous'; ?></strong>

          <span>
            <?php 
            for($i=1; $i<=5; $i++){
                echo $i <= $r['rating'] ? "⭐" : "☆";
            }
            ?>
          </span>
        </div>

      </div>
    <?php endforeach; ?>

  </div>
</div>

</section>
