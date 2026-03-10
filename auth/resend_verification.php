<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/mailer.php';

csrf_verify();

$email = trim($_POST['email'] ?? '');

if ($email === '') {
  $_SESSION['flash_err'] = "Please enter your email.";
  header("Location: " . BASE_URL . "/auth/verify_notice.php");
  exit;
}

$_SESSION['verify_email'] = $email;

$generic = "If the email exists and is not yet verified, we sent a verification link.";

$stmt = $conn->prepare("SELECT id, is_verified, verification_sent_at FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || (int)$user['is_verified'] === 1) {
  $_SESSION['flash_ok'] = $generic;
  header("Location: " . BASE_URL . "/auth/verify_notice.php");
  exit;
}

if (!empty($user['verification_sent_at'])) {
  $last = strtotime($user['verification_sent_at']);
  if ($last !== false && (time() - $last) < 60) {
    $_SESSION['flash_ok'] = "Please wait a moment before requesting another verification email.";
    header("Location: " . BASE_URL . "/auth/verify_notice.php");
    exit;
  }
}

$token = bin2hex(random_bytes(32));
$expiresAt = date('Y-m-d H:i:s', time() + 24 * 3600);

$upd = $conn->prepare("
  UPDATE users
  SET verification_token = ?, verification_token_expires_at = ?, verification_sent_at = NOW()
  WHERE id = ?
");
$upd->bind_param("ssi", $token, $expiresAt, $user['id']);
$upd->execute();

$cfg = require __DIR__ . '/../config/env.php';
$link = rtrim($cfg['APP_URL'], '/') . "/auth/verify.php?token=" . urlencode($token) . "&email=" . urlencode($email);

$subject = "Verify your MilkyWay account";
$html = "
  <div style='font-family:Arial,sans-serif;line-height:1.6'>
    <h2>Verify your email</h2>
    <p>Click the button below to verify your account (expires in 24 hours).</p>
    <p><a href='{$link}' style='display:inline-block;padding:12px 16px;background:#ff6f7a;color:#fff;text-decoration:none;border-radius:10px;font-weight:700'>Verify Email</a></p>
  </div>
";

send_email($email, $subject, $html);

$_SESSION['flash_ok'] = "A new verification email has been sent.";
header("Location: " . BASE_URL . "/auth/verify_notice.php");
exit;