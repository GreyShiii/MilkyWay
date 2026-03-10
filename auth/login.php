<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

// redirect authenticated users away
if (function_exists('require_guest')) {
  require_guest();
} else {
  if (!empty($_SESSION['user_id'])) {
    header("Location: ../index.php?page=home");
    exit;
  }
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
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/main.css?v=<?php echo filemtime(__DIR__ . '/../public/css/main.css'); ?>">
  <title>Login - MilkyWay</title>
</head>

<body>

  <?php require_once __DIR__ . '/../partials/navbar.php'; ?>

  <main class="page auth-page auth-page--login">
    <section class="auth-shell">
      <div class="auth-card auth-card--login">

        <div class="auth-left auth-left--login">
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

        <div class="auth-right auth-right--login">
          <div class="auth-mobile-brand">
            <h2 class="auth-mobile-brand-title">MilkyWay</h2>
            <p class="auth-mobile-brand-sub">Supporting moms. One feed at a time.</p>
          </div>

          <div class="auth-right-head">
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subcopy">Login to continue your journey.</p>
            <p class="auth-subtitle auth-subtitle--inline auth-subtitle--login-link">
              No account? <a href="<?= BASE_URL ?>/auth/register.php">Register</a>
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

          <form class="auth-form auth-form--login" action="<?= BASE_URL ?>/auth/login_post.php" method="POST">
            <?= csrf_input(); ?>

            <div class="auth-field">
              <label class="auth-label" for="login_email">Email</label>
              <input
                id="login_email"
                class="auth-input"
                type="email"
                name="email"
                placeholder="you@example.com"
                required>
            </div>

            <div class="auth-field">
              <label class="auth-label" for="login_pw">Password</label>
              <div class="auth-pass-wrap">
                <input
                  id="login_pw"
                  class="auth-input auth-input--pw"
                  type="password"
                  name="password"
                  placeholder="Enter your password"
                  required>
                <button class="auth-eye" type="button" onclick="togglePw('login_pw', this)" aria-label="Show password" aria-pressed="false">
                  <img class="eye-icon eye-icon--show" src="<?= BASE_URL ?>/public/images/view.png" alt="">
                  <img class="eye-icon eye-icon--hide" src="<?= BASE_URL ?>/public/images/hide.png" alt="">
                </button>
              </div>
            </div>

            <div class="auth-row auth-row--end">
              <a class="auth-forgot" href="<?= BASE_URL ?>/auth/forgot.php">Forgot Password?</a>
            </div>

            <button class="auth-btn auth-btn--login" type="submit">Login</button>

            <div class="auth-divider auth-divider--login">
              <span></span>
              <em>or</em>
              <span></span>
            </div>

            <a class="auth-google auth-google--login" href="<?= BASE_URL ?>/auth/google_start.php">
              <img src="<?= BASE_URL ?>/public/images/google.png" class="google-icon" alt="Google">
              Continue with Google
            </a>

            <a class="auth-google auth-google--login auth-guest-link" href="<?= BASE_URL ?>/auth/guest.php">
              Continue as Guest
            </a>
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