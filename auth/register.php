<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

if (function_exists('require_guest')) {
  require_guest();
} else {
  if (!empty($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/index.php?page=home");
    exit;
  }
}

$err = $_SESSION['flash_err'] ?? '';
$ok  = $_SESSION['flash_ok'] ?? '';
unset($_SESSION['flash_err'], $_SESSION['flash_ok']);
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css?v=<?php echo filemtime(__DIR__ . '/../public/css/main.css'); ?>">
  <title>Register - MilkyWay</title>
</head>

<body>

  <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

  <main class="page auth-page auth-page--register">
    <section class="auth-shell">
      <div class="auth-card auth-card--register">

        <div class="auth-left auth-left--register">
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

        <div class="auth-right auth-right--register">
          <div class="auth-mobile-brand">
            <h2 class="auth-mobile-brand-title">MilkyWay</h2>
            <p class="auth-mobile-brand-sub">Supporting moms. One feed at a time.</p>
          </div>

          <div class="auth-right-head">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle auth-subtitle--inline">
              Already have an account?
              <a href="<?= BASE_URL ?>/auth/login.php">Login</a>
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

          <form class="auth-form auth-form--register" action="<?= BASE_URL ?>/auth/register_post.php" method="POST">
            <?= csrf_input(); ?>

            <div class="auth-field">
              <label class="auth-label" for="reg_username">Username</label>
              <input
                id="reg_full_name"
                class="auth-input"
                type="text"
                name="username"
                placeholder="Juan"
                required>
            </div>

            <div class="auth-field">
              <label class="auth-label" for="reg_email">Email</label>
              <input
                id="reg_email"
                class="auth-input"
                type="email"
                name="email"
                placeholder="you@example.com"
                required>
            </div>

            <div class="auth-field">
              <label class="auth-label" for="reg_pw">Password</label>
              <div class="auth-pass-wrap">
                <input
                  id="reg_pw"
                  class="auth-input auth-input--pw"
                  type="password"
                  name="password"
                  placeholder="Create a password"
                  required>
                <button class="auth-eye" type="button" onclick="togglePw('reg_pw', this)" aria-label="Show password" aria-pressed="false">
                  <img class="eye-icon eye-icon--show" src="<?= BASE_URL ?>/public/images/view.png" alt="">
                  <img class="eye-icon eye-icon--hide" src="<?= BASE_URL ?>/public/images/hide.png" alt="">
                </button>
              </div>
            </div>

            <div class="auth-field">
              <label class="auth-label" for="reg_pw2">Confirm Password</label>
              <div class="auth-pass-wrap">
                <input
                  id="reg_pw2"
                  class="auth-input auth-input--pw"
                  type="password"
                  name="confirm_password"
                  placeholder="Confirm your password"
                  required>
                <button class="auth-eye" type="button" onclick="togglePw('reg_pw2', this)" aria-label="Show password" aria-pressed="false">
                  <img class="eye-icon eye-icon--show" src="<?= BASE_URL ?>/public/images/view.png" alt="">
                  <img class="eye-icon eye-icon--hide" src="<?= BASE_URL ?>/public/images/hide.png" alt="">
                </button>
              </div>
            </div>

            <button class="auth-btn auth-btn--register" type="submit">Register</button>
          </form>
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