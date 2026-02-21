<?php
require_once __DIR__ . '/../helpers/lang.php';

$page = $_GET['page'] ?? 'home';

$isHome     = in_array($page, ['home'], true);
$isWatch    = in_array($page, ['watch','watch_view'], true);
$isArticles = in_array($page, ['articles','articles_cat','article_view'], true);
$isBuddy    = in_array($page, ['locator','clinic_connect'], true); 
?>

<div id="pageLoader" class="page-loader" aria-hidden="true">
  <div class="page-loader__box">
    <div class="page-loader__spinner"></div>
    <div class="page-loader__text"><?= htmlspecialchars(t('loading')) ?></div>
  </div>
</div>


<footer class="footer-container">
  <a href="/MILKYWAY/index.php?page=home" class="<?= $isHome ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-home.png" alt="">
    <p class="image-title"><?= htmlspecialchars(t('nav_home')) ?></p>
  </a>

  <a href="/MILKYWAY/index.php?page=watch" class="<?= $isWatch ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-video.png" alt="">
    <p class="image-title"><?= htmlspecialchars(t('nav_watch')) ?></p>
  </a>

  <a href="/MILKYWAY/index.php?page=articles" class="<?= $isArticles ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-book.png" alt="">
    <p class="image-title"><?= htmlspecialchars(t('nav_articles')) ?></p>
  </a>

  <a href="/MILKYWAY/index.php?page=locator" class="<?= $isBuddy ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-location.png" alt="">
    <p class="image-title"><?= htmlspecialchars(t('nav_locator')) ?></p>
  </a>
</footer>
