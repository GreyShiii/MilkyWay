<?php
$page = $_GET['page'] ?? 'home';

$isHome     = in_array($page, ['home'], true);
$isWatch    = in_array($page, ['watch','watch_view'], true);
$isArticles = in_array($page, ['articles','articles_cat','article_view'], true);
$isBuddy    = in_array($page, ['locator','clinic_connect'], true); 
?>

<footer class="footer-container">
  <a href="/MILKYWAY/index.php?page=home" class="<?= $isHome ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-home.png" alt="">
    <p class="image-title">Home</p>
  </a>

  <a href="/MILKYWAY/index.php?page=watch" class="<?= $isWatch ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-video.png" alt="">
    <p class="image-title">Watch</p>
  </a>

  <a href="/MILKYWAY/index.php?page=articles" class="<?= $isArticles ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-book.png" alt="">
    <p class="image-title">Articles</p>
  </a>

  <a href="/MILKYWAY/index.php?page=locator" class="<?= $isBuddy ? 'is-active' : '' ?>">
    <img src="/MILKYWAY/public/images/footer-location.png" alt="">
    <p class="image-title">Buddy</p>
  </a>
</footer>
