<?php
require_once __DIR__ . '/../helpers/lang.php';
$currentLang = lang();
?>

<div id="menuOverlay" class="menu-overlay" aria-hidden="true"></div>

<aside id="menuDrawer" class="menu-drawer" aria-hidden="true">
  <div class="menu-inner">

    <div class="menu-top">
      <div class="menu-brand">
        <img class="menu-logo" src="/MILKYWAY/public/images/logo.png" alt="Milky Way">
        <h2 class="menu-title">Milky Way</h2>
        <p class="menu-subtitle">A Breastfeeding Support App</p>
      </div>
    </div>

    <div class="menu-section">
      <button id="openLang" class="menu-btn" type="button"><?= htmlspecialchars(t('menu_language')) ?></button>

      <a class="menu-btn" href="/MILKYWAY/index.php?page=locator&mode=clinic"> <?= htmlspecialchars(t('menu_clinic')) ?></a>
      <a class="menu-btn" href="/MILKYWAY/index.php?page=about"><?= htmlspecialchars(t('menu_about')) ?></a>
      <a class="menu-btn" href="/MILKYWAY/index.php?page=feedback"><?= htmlspecialchars(t('menu_feedback')) ?></a>
    </div>

    <div class="menu-bottom">
      <a class="menu-nav" href="/MILKYWAY/index.php?page=home">
        <span class="menu-nav-ic"></span>
        <span><?= htmlspecialchars(t('nav_home')) ?></span>
      </a>

      <a class="menu-nav" href="/MILKYWAY/index.php?page=watch">
        <span class="menu-nav-ic"></span>
        <span><?= htmlspecialchars(t('nav_watch')) ?></span>
      </a>

      <a class="menu-nav" href="/MILKYWAY/index.php?page=articles">
        <span class="menu-nav-ic"></span>
        <span><?= htmlspecialchars(t('nav_articles')) ?></span>
      </a>

      <a class="menu-nav" href="/MILKYWAY/index.php?page=locator">
        <span class="menu-nav-ic"></span>
        <span><?= htmlspecialchars(t('nav_locator')) ?></span>
      </a>
    </div>

  </div>
</aside>

<div id="langModal" class="lang-modal" aria-hidden="true">
  <div class="lang-sheet">
    <div class="lang-head">
      <div class="lang-title"><?= htmlspecialchars(t('lang_title')) ?></div>
      <button id="closeLang" class="lang-close" type="button">✕</button>
    </div>

    <form class="lang-options" action="/MILKYWAY/process/set_language.php" method="POST">
      <button class="lang-option <?= $currentLang === 'en' ? 'is-active' : '' ?>" type="submit" name="lang" value="en">
        <?= htmlspecialchars(t('lang_en')) ?>
      </button>

      <button class="lang-option <?= $currentLang === 'fil' ? 'is-active' : '' ?>" type="submit" name="lang" value="fil">
        <?= htmlspecialchars(t('lang_fil')) ?>
      </button>
    </form>
  </div>
</div>
