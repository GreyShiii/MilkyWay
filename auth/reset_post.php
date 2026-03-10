<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/tokens.php';

csrf_verify();

$email = trim($_POST['email'] ?? '');
$token = trim($_POST['token'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($email === '' || $token === '' || $password === '' || $confirmPassword === '') {
  $_SESSION['flash_err'] = "All fields are required.";
  header("Location: " . BASE_URL . "/auth/reset.php?token=" . urlencode($token) . "&email=" . urlencode($email));
  exit;
}

if ($password !== $confirmPassword) {
  $_SESSION['flash_err'] = "Passwords do not match.";
  header("Location: " . BASE_URL . "/auth/reset.php?token=" . urlencode($token) . "&email=" . urlencode($email));
  exit;
}

if (strlen($password) < 8) {
  $_SESSION['flash_err'] = "Password must be at least 8 characters.";
  header("Location: " . BASE_URL . "/auth/reset.php?token=" . urlencode($token) . "&email=" . urlencode($email));
  exit;
}

$stmt = $conn->prepare("
  SELECT id, reset_token_hash, reset_token_expires_at
  FROM users
  WHERE email = ?
  LIMIT 1
");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (
  !$user ||
  empty($user['reset_token_hash']) ||
  empty($user['reset_token_expires_at']) ||
  !hash_equals($user['reset_token_hash'], hash_token($token)) ||
  strtotime($user['reset_token_expires_at']) === false ||
  strtotime($user['reset_token_expires_at']) < time()
) {
  $_SESSION['flash_err'] = "This reset link is invalid or has expired.";
  header("Location: " . BASE_URL . "/auth/forgot.php");
  exit;
}

$newHash = password_hash($password, PASSWORD_DEFAULT);

$upd = $conn->prepare("
  UPDATE users
  SET password_hash = ?,
      reset_token_hash = NULL,
      reset_token_expires_at = NULL,
      reset_sent_at = NULL
  WHERE id = ?
");
$upd->bind_param("si", $newHash, $user['id']);
$upd->execute();

$_SESSION['flash_ok'] = "Your password has been updated.";
header("Location: " . BASE_URL . "/auth/reset_success.php");
exit;