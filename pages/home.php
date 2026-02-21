<?php
require_once __DIR__ . '/../helpers/lang.php';

$dailyTips = [
  'en' => [
    "Stay hydrated! Drinking plenty of water helps maintain your milk supply.",
    "Proper latch prevents nipple pain and helps your baby feed efficiently.",
    "Feed on demand to support healthy milk production.",
    "Rest whenever possible—fatigue can affect milk supply.",
    "Alternate breasts during feeds to maintain balanced milk flow.",
    "Skin-to-skin contact boosts bonding and breastfeeding success.",
    "Eat balanced meals to support your body and milk quality."
  ],
  'fil' => [
    "Uminom ng sapat na tubig! Nakakatulong ito para mapanatili ang supply ng gatas.",
    "Ang tamang latch ay nakakaiwas sa pananakit ng utong at mas epektibong pagpapasuso.",
    "Magpasuso kapag hinihingi ng sanggol para masuportahan ang produksyon ng gatas.",
    "Magpahinga kapag may pagkakataon—ang pagod ay maaaring makaapekto sa supply ng gatas.",
    "Salitan ang pagpapasuso sa magkabilang suso para balanse ang daloy ng gatas.",
    "Ang skin-to-skin ay nakakatulong sa bonding at tagumpay sa pagpapasuso.",
    "Kumain ng masustansya para suportahan ang katawan at kalidad ng gatas."
  ],
];

$dayIndex = (int)date('z');
$langCode = lang();
$list = $dailyTips[$langCode] ?? $dailyTips['en'];
$tip = $list[$dayIndex % count($list)];
?>

<main class="page">

  <section class="hero">
    <div class="hero-card">
      <img class="hero-img" src="public/images/home-photo1.jpg" alt="">
      <p class="hero-quote">
        <?= htmlspecialchars(t('home_quote')) ?>
      </p>
    </div>
  </section>

  <section class="feature-grid">

    <div class="feature-container">
      <a href="index.php?page=watch" class="feature-card">
        <div class="card-icon">
          <img src="public/images/home-video.png" alt="">
        </div>
        <div class="card-text">
          <h3><?= htmlspecialchars(t('home_feature_watch')) ?></h3>
          <p><?= htmlspecialchars(t('home_feature_watch_sub')) ?></p>
        </div>
      </a>
    </div>

    <div class="feature-container">
      <a href="index.php?page=articles" class="feature-card">
        <div class="card-icon">
          <img src="public/images/home-book.png" alt="">
        </div>
        <div class="card-text">
          <h3><?= htmlspecialchars(t('home_feature_articles')) ?></h3>
          <p><?= htmlspecialchars(t('home_feature_articles_sub')) ?></p>
        </div>
      </a>
    </div>

    <div class="feature-container">
      <a href="index.php?page=didyouknow" class="feature-card">
        <div class="card-icon">
          <img src="public/images/home-community.png" alt="">
        </div>
        <div class="card-text">
          <h3><?= htmlspecialchars(t('home_feature_didk')) ?></h3>
          <p><?= htmlspecialchars(t('home_feature_didk_sub')) ?></p>
        </div>
      </a>
    </div>

    <div class="feature-container">
      <a href="index.php?page=locator" class="feature-card">
        <div class="card-icon">
          <img src="public/images/home-location.png" alt="">
        </div>
        <div class="card-text">
          <h3><?= htmlspecialchars(t('home_feature_buddy')) ?></h3>
          <p><?= htmlspecialchars(t('home_feature_buddy_sub')) ?></p>
        </div>
      </a>
    </div>

  </section>

  <section class="daily-tip">
    <h2><?= htmlspecialchars(t('home_daily_tip_title')) ?></h2>
    <p><?= htmlspecialchars($tip) ?></p>
  </section>

</main>
