<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/app.php';

$email = trim($_GET['email'] ?? '');
$token = trim($_GET['token'] ?? '');

if ($email === '' || $token === '') {
  $_SESSION['flash_err'] = "Invalid verification link.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

$stmt = $conn->prepare("
  SELECT id, is_verified, verification_token_expires_at
  FROM users
  WHERE email = ? AND verification_token = ?
  LIMIT 1
");
$stmt->bind_param("ss", $email, $token);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
  $_SESSION['flash_err'] = "Verification link is invalid or already used.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

if ((int)$user['is_verified'] === 1) {
  $_SESSION['flash_ok'] = "Email already verified. You can log in.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

if (!empty($user['verification_token_expires_at'])) {
  $exp = strtotime($user['verification_token_expires_at']);
  if ($exp !== false && $exp < time()) {
    $_SESSION['flash_err'] = "Verification link expired. Please resend verification.";
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
  }
}

$upd = $conn->prepare("
  UPDATE users
  SET is_verified = 1,
      verification_token = NULL,
      verification_token_expires_at = NULL
  WHERE id = ?
");
$upd->bind_param("i", $user['id']);
$upd->execute();

$_SESSION['flash_ok'] = "Email verified successfully! Please log in.";
header("Location: " . BASE_URL . "/auth/login.php");
exit;
