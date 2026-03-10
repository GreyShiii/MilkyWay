<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

require_guest();

$err = $_SESSION['flash_err'] ?? '';
$ok  = $_SESSION['flash_ok'] ?? '';
unset($_SESSION['flash_err'], $_SESSION['flash_ok']);

$email = $_SESSION['verify_email'] ?? '';

if ($email) {
  $stmt = $conn->prepare("SELECT is_verified FROM users WHERE email = ? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();

  if ($row && (int)$row['is_verified'] === 1) {
    unset($_SESSION['verify_email']);
    $_SESSION['flash_ok'] = "Email already verified. You can log in.";
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css">
  <title>Verify Email - MilkyWay</title>
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
          <div class="verify-icon" aria-hidden="true">
            ✉
          </div>

          <h1 class="verify-title">Verify your email</h1>

          <p class="verify-text">
            We’ve sent a verification link to your email. Please check your inbox and click the link to activate your account.
          </p>

          <?php if ($email): ?>
            <p class="verify-email">
              <?= htmlspecialchars($email) ?>
            </p>
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

          <form class="verify-form" action="<?= BASE_URL ?>/auth/resend_verification.php" method="POST">
            <?= csrf_input(); ?>
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <button class="auth-btn auth-btn--verify" type="submit">Resend verification email</button>
          </form>

          <a class="verify-back" href="<?= BASE_URL ?>/auth/login.php">← Back to Login</a>
        </div>
      </div>
    </div>
  </section>
</main>

</body>
</html>