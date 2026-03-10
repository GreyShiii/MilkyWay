<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/tokens.php';

csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . BASE_URL . '/auth/forgot.php');
  exit;
}

$email = trim($_POST['email'] ?? '');

if ($email === '') {
  $_SESSION['flash_err'] = 'Please enter your email.';
  header('Location: ' . BASE_URL . '/auth/forgot.php');
  exit;
}

$_SESSION['reset_email'] = $email;

$genericMsg = 'If the email exists, we sent a password reset link.';

$stmt = $conn->prepare("SELECT id, reset_sent_at FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
  $_SESSION['flash_ok'] = $genericMsg;
  header('Location: ' . BASE_URL . '/auth/forgot_notice.php');
  exit;
}

// Cooldown 60s
if (!empty($user['reset_sent_at'])) {
  $last = strtotime($user['reset_sent_at']);
  if ($last !== false && (time() - $last) < 60) {
    $_SESSION['flash_ok'] = 'Please wait a moment before requesting another reset email.';
    header('Location: ' . BASE_URL . '/auth/forgot_notice.php');
    exit;
  }
}

$token = make_token(32);
$tokenHash = hash_token($token);
$expiresAt = add_minutes_mysql(30);
$sentAt = now_mysql();

$upd = $conn->prepare("
  UPDATE users
  SET reset_token_hash = ?, reset_token_expires_at = ?, reset_sent_at = ?
  WHERE id = ?
");
$upd->bind_param("sssi", $tokenHash, $expiresAt, $sentAt, $user['id']);
$upd->execute();

$cfg = require __DIR__ . '/../config/env.php';
$appUrl = rtrim($cfg['APP_URL'], '/');
$link = $appUrl . "/auth/reset.php?token=" . urlencode($token) . "&email=" . urlencode($email);

$subject = "Reset your MilkyWay password";
$html = "
  <div style='font-family:Arial,sans-serif;line-height:1.6'>
    <h2>Reset your password</h2>
    <p>We received a request to reset your password.</p>
    <p>
      <a href='{$link}' style='display:inline-block;padding:12px 16px;background:#ff6f7a;color:#fff;text-decoration:none;border-radius:10px;font-weight:700'>
        Reset Password
      </a>
    </p>
    <p>This link expires in 30 minutes. If you didn’t request this, ignore this email.</p>
  </div>
";

send_email($email, $subject, $html);

$_SESSION['flash_ok'] = $genericMsg;
header('Location: ' . BASE_URL . '/auth/forgot_notice.php');
exit;