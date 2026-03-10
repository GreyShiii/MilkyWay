<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../helpers/lang.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/auth.php';

$currentLang = lang();

$user = function_exists('auth_user') ? auth_user() : null;
$isAuthed = !empty($user);
$isAdmin = $isAuthed && (($user['role'] ?? '') === 'admin');

$userName = $user['username'] ?? ($_SESSION['username'] ?? '');
$initial  = $userName !== '' ? strtoupper(substr($userName, 0, 1)) : 'G';
?>

<div id="menuOverlay" class="menu-overlay" aria-hidden="true"></div>

<aside id="menuDrawer" class="menu-drawer" aria-hidden="true">
  <div class="menu-inner">

    <div class="menu-top">
      <div class="menu-brand">
        <img class="menu-logo" src="<?= BASE_URL ?>/public/images/logo.png" alt="Milky Way">
        <h2 class="menu-title">Milky Way</h2>
        <p class="menu-subtitle">Breastfeeding Support</p>
      </div>
    </div>

    <div class="menu-scroll">

      <div class="menu-section">
        <button id="openLang" class="menu-btn" type="button"><?= htmlspecialchars(t('menu_language')) ?></button>
        <a class="menu-btn" href="index.php?page=locator&mode=clinic"><?= htmlspecialchars(t('menu_clinic')) ?></a>
        <a class="menu-btn" href="index.php?page=about"><?= htmlspecialchars(t('menu_about')) ?></a>
        <a class="menu-btn" href="index.php?page=feedback"><?= htmlspecialchars(t('menu_feedback')) ?></a>
        <a class="menu-btn" href="index.php?page=tracker"><?= htmlspecialchars(t('menu_tracker')) ?></a>
      </div>

      <nav class="menu-links">

        <a class="menu-nav" href="index.php?page=home">
          <span class="menu-button-color"><?= htmlspecialchars(t('nav_home')) ?></span>
        </a>

        <a class="menu-nav" href="index.php?page=watch">
          <span class="menu-button-color"><?= htmlspecialchars(t('nav_watch')) ?></span>
        </a>

        <a class="menu-nav" href="index.php?page=articles">
          <span class="menu-button-color"><?= htmlspecialchars(t('nav_articles')) ?></span>
        </a>

        <a class="menu-nav" href="index.php?page=locator">
          <span class="menu-button-color"><?= htmlspecialchars(t('nav_locator')) ?></span>
        </a>

      </nav>

    </div>

    <div class="menu-footer">

      <?php if ($isAuthed): ?>

        <div class="menu-user">
          <div class="menu-avatar"><?= htmlspecialchars($initial) ?></div>
          <div class="menu-user-name"><?= htmlspecialchars($userName) ?></div>
        </div>

        <?php if ($isAdmin): ?>
          <a class="menu-authlink menu-adminlink" href="index.php?page=admin_activity">
            <?= htmlspecialchars(t('menu_admin_panel')) ?>
          </a>
        <?php endif; ?>

        <a class="menu-authlink" href="<?= BASE_URL ?>/auth/logout.php">Log Out</a>

      <?php else: ?>

        <a class="menu-authlink" href="<?= BASE_URL ?>/auth/login.php">Sign In</a>

      <?php endif; ?>

    </div>

  </div>
</aside>

<div id="langModal" class="lang-modal" aria-hidden="true">
  <div class="lang-sheet">
    <div class="lang-head">
      <p class="lang-title"><?= htmlspecialchars(t('lang_title')) ?></p>
      <button id="closeLang" class="lang-close" aria-label="Close">&times;</button>
    </div>
    <form action="<?= BASE_URL ?>/process/set_language.php" method="POST">
      <div class="lang-options">
        <button type="submit" name="lang" value="en" class="lang-option<?= $currentLang === 'en' ? ' is-active' : '' ?>"><?= htmlspecialchars(t('lang_en')) ?></button>
        <button type="submit" name="lang" value="fil" class="lang-option<?= $currentLang === 'fil' ? ' is-active' : '' ?>"><?= htmlspecialchars(t('lang_fil')) ?></button>
      </div>
    </form>
  </div>
</div>