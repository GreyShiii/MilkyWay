<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

require_guest();

$err = $_SESSION['flash_err'] ?? $_SESSION['flash_error'] ?? '';
$ok  = $_SESSION['flash_ok'] ?? $_SESSION['flash_success'] ?? '';
unset($_SESSION['flash_err'], $_SESSION['flash_error'], $_SESSION['flash_ok'], $_SESSION['flash_success']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css">
  <title>Forgot Password - MilkyWay</title>
</head>
<body>

<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

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
          <h1 class="auth-title">Forgot your password?</h1>
          <p class="auth-subcopy">
            Enter your email address and we will send you a link to reset your password.
          </p>
        </div>

        <?php if ($err): ?>
          <div class="auth-alert auth-alert--err">
            <?= htmlspecialchars($err) ?>
          </div>
        <?php endif; ?>

        <?php if ($ok): ?>
          <div class="auth-alert auth-alert--ok">
            <?= htmlspecialchars($ok) ?>
          </div>
        <?php endif; ?>

        <form class="auth-form auth-form--forgot" action="<?= BASE_URL ?>/auth/forgot_send.php" method="POST">
          <?= csrf_input(); ?>

          <div class="auth-field">
            <label class="auth-label" for="forgot_email">Email</label>
            <input
              id="forgot_email"
              class="auth-input"
              type="email"
              name="email"
              placeholder="you@example.com"
              required
            >
          </div>

          <button class="auth-btn auth-btn--forgot" type="submit">Send Reset Link</button>

          <a class="verify-back" href="<?= BASE_URL ?>/auth/login.php">← Back to Login</a>
        </form>
      </div>
    </div>
  </section>
</main>

</body>
</html>