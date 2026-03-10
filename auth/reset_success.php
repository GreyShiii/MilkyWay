<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/auth.php';

require_guest();

$ok = $_SESSION['flash_ok'] ?? '';
unset($_SESSION['flash_ok']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css">
  <title>Password Reset Successful - MilkyWay</title>
</head>
<body>

<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<main class="page auth-page auth-page--verify">
  <section class="auth-shell">
    <div class="auth-card auth-card--verify">

      <div class="auth-left auth-left--verify">
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

      <div class="auth-right auth-right--verify">
        <div class="auth-mobile-brand">
          <h2 class="auth-mobile-brand-title">MilkyWay</h2>
          <p class="auth-mobile-brand-sub">Supporting moms. One feed at a time.</p>
        </div>

        <div class="verify-wrap">
          <div class="verify-icon" aria-hidden="true">✓</div>

          <h1 class="verify-title">Password Reset Successfully</h1>

          <p class="verify-text">
            Your password has been updated. You can now log in with your new password.
          </p>

          <?php if ($ok): ?>
            <div class="auth-alert auth-alert--ok">
              <?= htmlspecialchars($ok) ?>
            </div>
          <?php endif; ?>

          <a class="auth-btn auth-btn--verify" href="<?= BASE_URL ?>/auth/login.php" style="text-decoration:none;display:flex;align-items:center;justify-content:center;">
            Go to Login
          </a>
        </div>
      </div>
    </div>
  </section>
</main>

</body>
</html>