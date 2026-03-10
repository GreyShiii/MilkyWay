<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/csrf.php';

require_guest();

$err = $_SESSION['flash_err'] ?? $_SESSION['flash_error'] ?? '';
$ok  = $_SESSION['flash_ok'] ?? $_SESSION['flash_success'] ?? '';
unset($_SESSION['flash_err'], $_SESSION['flash_error'], $_SESSION['flash_ok'], $_SESSION['flash_success']);

$email = $_SESSION['reset_email'] ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css">
  <title>Check Your Email - MilkyWay</title>
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
          <div class="verify-icon" aria-hidden="true">✉</div>

          <h1 class="verify-title">Check your email</h1>

          <p class="verify-text">
            We've sent a password reset link to your email address. Please check your inbox.
          </p>

          <?php if ($email): ?>
            <p class="verify-email"><?= htmlspecialchars($email) ?></p>
          <?php endif; ?>

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

          <form class="verify-form" action="<?= BASE_URL ?>/auth/forgot_send.php" method="POST">
            <?= csrf_input(); ?>
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <button class="auth-btn auth-btn--verify" type="submit">Resend Email</button>
          </form>

          <a class="verify-back" href="<?= BASE_URL ?>/auth/login.php">← Back to Login</a>
        </div>
      </div>
    </div>
  </section>
</main>

</body>
</html>