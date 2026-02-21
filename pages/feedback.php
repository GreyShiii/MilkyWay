<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/lang.php';

$sql = "SELECT COUNT(*) AS total_reviews, AVG(rating) AS avg_rating FROM feedback";
$res = $conn->query($sql);

$totalReviews = 0;
$avgRating = 0.0;

if ($res) {
  $row = $res->fetch_assoc();
  $totalReviews = (int)($row['total_reviews'] ?? 0);
  $avgRating = $row['avg_rating'] !== null ? (float)$row['avg_rating'] : 0.0;
}

$avgRatingFormatted = number_format($avgRating, 1);
?>

<main class="page feedback-page">

  <section class="feedback-summary">
    <div class="rating-card">
      <div class="rating-icon">⭐</div>

      <p class="rating-label">App Rating</p>

      <p class="rating-value">
        <span class="rating-score"><?= $totalReviews > 0 ? $avgRatingFormatted : '0.0' ?></span>
        <span class="rating-max">/5.0</span>
      </p>

      <p class="rating-count">
        Based on <span id="reviewCount"><?= $totalReviews ?></span> review<?= $totalReviews === 1 ? '' : 's' ?>
      </p>
    </div>
  </section>

  <section class="feedback-stars">
    <h3>How was your experience?</h3>
    <p class="tap-text">Tap to rate</p>

    <div class="stars" id="starRating">
      <span class="star" data-value="1">☆</span>
      <span class="star" data-value="2">☆</span>
      <span class="star" data-value="3">☆</span>
      <span class="star" data-value="4">☆</span>
      <span class="star" data-value="5">☆</span>
    </div>

    

    <p class="feedback-thanks" id="feedbackThanks"></p>
  </section>

  <section class="feedback-likes">
    <h3>What did you like the most?</h3>

    <div class="like-grid" id="likeGrid">
      <button type="button" class="like-card" data-like="design">App Design</button>
      <button type="button" class="like-card" data-like="content">Content Quality</button>
      <button type="button" class="like-card" data-like="easy">Easy to Use</button>
      <button type="button" class="like-card" data-like="tips">Helpful Tips</button>
    </div>
  </section>

  <button type="button" class="feedback-submit" id="btnSubmitFeedback">
      Submit Feedback
    </button>

    <!-- THANK YOU POPUP -->
<div id="thanksOverlay" class="thanks-overlay" aria-hidden="true">
  <div class="thanks-modal" role="dialog" aria-modal="true" aria-labelledby="thanksTitle">
    <div class="thanks-icon">
      <span class="thanks-heart">❤</span>
    </div>

    <h2 id="thanksTitle" class="thanks-title">Thank You!</h2>
    <p class="thanks-text">
      Your feedback helps us make MilkyWay better for <br> all moms
    </p>

    <button type="button" id="btnThanksClose" class="thanks-close">Close</button>
  </div>
</div>

</main>
