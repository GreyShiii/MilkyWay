<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

require_login();

$u = auth_user();
if (!$u) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

if (!empty($u['username']) && strpos($u['username'], 'googleuser_') !== 0) {
  header("Location: " . BASE_URL . "/index.php?page=home");
  exit;
}

$err = $_SESSION['flash_err'] ?? '';
$ok  = $_SESSION['flash_ok'] ?? '';
unset($_SESSION['flash_err'], $_SESSION['flash_ok']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css">
  <title>Choose Username - MilkyWay</title>
</head>
<body>

<main class="page auth-page auth-page--forgot">
  <section class="auth-shell">
    <div class="auth-card auth-card--forgot">

      <div class="auth-left auth-left--forgot">
        <div class="auth-left-overlay"></div>
        <div class="auth-left-inner">
          <div class="auth-badge">
            <img class="auth-badge-icon" src="<?= BASE_URL ?>/public/images/logo.png" alt="MilkyWay">
          </div>
          <h2 class="auth-left-title">MilkyWay</h2>
          <p class="auth-left-sub">
            Supporting moms.<br>
            One feed at a time.
          </p>
        </div>
      </div>

      <div class="auth-right auth-right--forgot">
        <div class="auth-mobile-brand">
          <h2 class="auth-mobile-brand-title">MilkyWay</h2>
          <p class="auth-mobile-brand-sub">Supporting moms. One feed at a time.</p>
        </div>

        <div class="auth-right-head">
          <h1 class="auth-title">Choose Username</h1>
          <p class="auth-subcopy">Before continuing, pick a username for your account.</p>
        </div>

        <?php if ($err): ?>
          <div class="auth-alert auth-alert--err"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>

        <?php if ($ok): ?>
          <div class="auth-alert auth-alert--ok"><?= htmlspecialchars($ok) ?></div>
        <?php endif; ?>

        <form class="auth-form auth-form--forgot" action="<?= BASE_URL ?>/auth/google_username_post.php" method="POST">
          <?= csrf_input(); ?>

          <div class="auth-field">
            <label class="auth-label" for="google_username">Username</label>
            <input
              id="google_username"
              class="auth-input"
              type="text"
              name="username"
              placeholder="Choose a username"
              required
              autofocus
            >
          </div>

          <button class="auth-btn auth-btn--forgot" type="submit">Continue</button>
        </form>
      </div>
    </div>
  </section>
</main>

</body>
</html>