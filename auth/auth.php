<?php
session_start();

// Redirect if already logged in or guest
if (isset($_SESSION['user_id']) || isset($_SESSION['is_guest'])) {
  header("Location: ../index.php");
  exit();
}

$mode = $_GET['mode'] ?? 'login';
$mode = in_array($mode, ['login','register']) ? $mode : 'login';

// Flash error
$error = $_SESSION['auth_error'] ?? '';
unset($_SESSION['auth_error']);

// Load AUTH layout head
include __DIR__ . '/../layout/auth_head.php';
?>

<main class="auth">

  <header class="auth-top">
    <div class="brand">
      <img src="/MILKYWAY/public/images/logo.png"
           class="brand-logo"
           alt="Milky Way"
           onerror="this.style.display='none'">
      <div class="brand-text">Milky Way</div>
    </div>
  </header>

  <section class="auth-content">
    <div class="avatar"></div>

    <h1 class="welcome">Welcome To Milky Way</h1>

    <div class="switch">
      <a class="switch-btn <?= $mode === 'login' ? 'is-active' : '' ?>" href="?mode=login">Log In</a>
      <a class="switch-btn <?= $mode === 'register' ? 'is-active' : '' ?>" href="?mode=register">Sign Up</a>
    </div>

    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($mode === 'login'): ?>
      <!-- LOGIN -->
      <form class="form" action="../process/process_login.php" method="POST">
        <label class="label">Email</label>
        <div class="field">
          <span class="ic"><img class="email-icon" src="/MilkyWay/public/images/email.png" alt=""></span>
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <label class="label">Password</label>
        <div class="field">
          <span class="ic"><img class="password-icon" src="/MilkyWay/public/images/password.png" alt=""></span>
          <input id="loginPass" type="password" name="password" placeholder="Enter your password" required>
          <button class="eye" type="button" onclick="togglePass('loginPass', this)">👁️</button>
        </div>

        <a class="forgot" href="#">Forgot Password?</a>

        <button class="primary" type="submit" name="login">Log In</button>

        <div class="divider"><span>Or continue as</span></div>

        <a class="ghost" href="../process/process_guest.php">Guest</a>
      </form>

    <?php else: ?>
      <form class="form" action="../process/process_register.php" method="POST">
        <label class="label">Username</label>
        <div class="field">
          <span class="ic"><img class="email-icon" src="/MilkyWay/public/images/user.png" alt=""></span>
          <input type="text" name="username" placeholder="Enter your username" required>
        </div>

        <label class="label">Email</label>
        <div class="field">
          <span class="ic"><img class="email-icon" src="/MilkyWay/public/images/email.png" alt=""></span>
          <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <label class="label">Password</label>
        <div class="field">
          <span class="ic"><img class="password-icon" src="/MilkyWay/public/images/password.png" alt=""></span>
          <input id="regPass" type="password" name="password" placeholder="Create a password" required>
          <button class="eye" type="button" onclick="togglePass('regPass', this)">👁️</button>
        </div>

        <button class="primary" type="submit" name="register">Sign Up</button>

        <div class="divider"><span>Or continue as</span></div>

        <a class="ghost" href="../process/process_guest.php">Guest</a>
      </form>
    <?php endif; ?>
  </section>

</main>

<script>
function togglePass(id, btn) {
  const el = document.getElementById(id);
  if (!el) return;
  el.type = el.type === 'password' ? 'text' : 'password';
  btn.style.opacity = el.type === 'text' ? '1' : '.6';
}
</script>

</body>
</html>
