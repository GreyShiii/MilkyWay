<?php
$dailyTips = [
  "Stay hydrated! Drinking plenty of water helps maintain your milk supply.",
  "Proper latch prevents nipple pain and helps your baby feed efficiently.",
  "Feed on demand to support healthy milk production.",
  "Rest whenever possible—fatigue can affect milk supply.",
  "Alternate breasts during feeds to maintain balanced milk flow.",
  "Skin-to-skin contact boosts bonding and breastfeeding success.",
  "Eat balanced meals to support your body and milk quality."
];

$dayIndex = date('z'); 
$tip = $dailyTips[$dayIndex % count($dailyTips)];
?>


<main class="page">

  <section class="hero">
    <div class="hero-card">
      <img class="hero-img" src="/MILKYWAY/public/images/home-photo1.jpg" alt="">
      <p class="hero-quote">
        “Every drop of breast milk is a drop of strength, comfort, and protection.”
      </p>
    </div>
  </section>

  <section class="feature-grid">

    <div class="feature-container">
      <a href="/MilkyWay/index.php?page=watch" class="feature-card">
        <div class="card-icon">
          <img src="/MILKYWAY/public/images/home-video.png" alt="Watch & Learn">
        </div>
        <div class="card-text">
          <h3>Watch & Learn</h3>
          <p>Video Library</p>
        </div>
      </a>
    </div>

    <div class="feature-container">
      <a href="/MILKYWAY/index.php?page=articles" class="feature-card">
        <div class="card-icon">
          <img src="/MILKYWAY/public/images/home-book.png" alt="Latch Library">
        </div>
        <div class="card-text">
          <h3>Latch Library</h3>
          <p>Articles</p>
        </div>
      </a>
    </div>

    <div class="feature-container">
      <a href="#" class="feature-card">
        <div class="card-icon">
          <img src="/MILKYWAY/public/images/home-community.png" alt="MomMates">
        </div>
        <div class="card-text">
          <h3>Did U Know?</h3>
          <p>Facts & Myths</p>
        </div>
      </a>
    </div>

    <div class="feature-container">
      <a href="/MILKYWAY/index.php?page=locator" class="feature-card">
        <div class="card-icon">
          <img src="/MILKYWAY/public/images/home-location.png" alt="Buddy">
        </div>
        <div class="card-text">
          <h3>Buddy</h3>
          <p>Find Locations</p>
        </div>
      </a>
    </div>

  </section>

  <section class="daily-tip">
    <h2>Daily Tip</h2>
    <p><?= htmlspecialchars($tip) ?></p>

  </section>

</main>
