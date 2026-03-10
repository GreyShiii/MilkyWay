<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/tokens.php';

require_guest();

$token = trim($_GET['token'] ?? '');
$email = trim($_GET['email'] ?? '');

$err = $_SESSION['flash_err'] ?? $_SESSION['flash_error'] ?? '';
$ok  = $_SESSION['flash_ok'] ?? $_SESSION['flash_success'] ?? '';
unset($_SESSION['flash_err'], $_SESSION['flash_error'], $_SESSION['flash_ok'], $_SESSION['flash_success']);

$tokenValid = false;

if ($token !== '' && $email !== '') {
  $stmt = $conn->prepare("
    SELECT id, reset_token_hash, reset_token_expires_at
    FROM users
    WHERE email = ?
    LIMIT 1
  ");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();

  if ($user && !empty($user['reset_token_hash']) && !empty($user['reset_token_expires_at'])) {
    $isHashValid = hash_equals($user['reset_token_hash'], hash_token($token));
    $isNotExpired = strtotime($user['reset_token_expires_at']) !== false && strtotime($user['reset_token_expires_at']) >= time();

    if ($isHashValid && $isNotExpired) {
      $tokenValid = true;
    }
  }
}

if (!$tokenValid && $err === '') {
  $err = "This reset link is invalid or has expired.";
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css">
  <title>Reset Password - MilkyWay</title>
</head>

<body>

  <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

  <main class="page auth-page auth-page--reset">
    <section class="auth-shell">
      <div class="auth-card auth-card--reset">

        <div class="auth-left auth-left--reset">
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

        <div class="auth-right auth-right--reset">
          <div class="auth-mobile-brand">
            <h2 class="auth-mobile-brand-title">MilkyWay</h2>
            <p class="auth-mobile-brand-sub">Supporting moms. One feed at a time.</p>
          </div>

          <div class="auth-right-head">
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subcopy">Create a new password for your account.</p>
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

          <?php if ($tokenValid): ?>
            <form class="auth-form auth-form--reset" action="<?= BASE_URL ?>/auth/reset_post.php" method="POST">
              <?= csrf_input(); ?>
              <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
              <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

              <div class="auth-field">
                <label class="auth-label" for="new_pw">New Password</label>
                <div class="auth-pass-wrap">
                  <input
                    id="new_pw"
                    class="auth-input auth-input--pw"
                    type="password"
                    name="password"
                    placeholder="Enter new password"
                    required>
                  <button class="auth-eye" type="button" onclick="togglePw('new_pw', this)" aria-label="Show password" aria-pressed="false">
                    <img class="eye-icon eye-icon--show" src="<?= BASE_URL ?>/public/images/view.png" alt="">
                    <img class="eye-icon eye-icon--hide" src="<?= BASE_URL ?>/public/images/hide.png" alt="">
                  </button>
                </div>
              </div>

              <div class="auth-field">
                <label class="auth-label" for="confirm_new_pw">Confirm Password</label>
                <div class="auth-pass-wrap">
                  <input
                    id="confirm_new_pw"
                    class="auth-input auth-input--pw"
                    type="password"
                    name="confirm_password"
                    placeholder="Confirm new password"
                    required>
                  <button class="auth-eye" type="button" onclick="togglePw('confirm_new_pw', this)" aria-label="Show password" aria-pressed="false">
                    <img class="eye-icon eye-icon--show" src="<?= BASE_URL ?>/public/images/view.png" alt="">
                    <img class="eye-icon eye-icon--hide" src="<?= BASE_URL ?>/public/images/hide.png" alt="">
                  </button>
                </div>
              </div>

              <button class="auth-btn auth-btn--reset" type="submit">Reset Password</button>
            </form>
          <?php else: ?>
            <a class="auth-btn auth-btn--reset" href="<?= BASE_URL ?>/auth/forgot.php" style="text-decoration:none;display:flex;align-items:center;justify-content:center;">
              Request New Link
            </a>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <script>
    function togglePw(id, btn) {
      const el = document.getElementById(id);
      if (!el || !btn) return;

      const isHidden = el.type === 'password';
      el.type = isHidden ? 'text' : 'password';

      btn.classList.toggle('is-active', isHidden);
      btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
      btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
    }
  </script>

</body>

</html>