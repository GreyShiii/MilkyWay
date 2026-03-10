<?php
require_once __DIR__ . '/../helpers/auth.php';
require_login();

if (function_exists('is_guest') && is_guest()) {
    $_SESSION['flash_err'] = "Please log in to view your dashboard.";
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$u = auth_user();
?>

<main class="page" style="padding-top:14px;">
  <div style="background:#fff;border-radius:18px;padding:16px;box-shadow:0 10px 22px rgba(0,0,0,0.07);">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">
      Logged in as: <?= htmlspecialchars($u['email']) ?>
    </p>
  </div>
</main>