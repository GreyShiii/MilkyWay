<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/tokens.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . BASE_URL . '/auth/login.php');
  exit;
}

$email = trim($_POST['email'] ?? '');
$token = trim($_POST['token'] ?? '');
$pass  = $_POST['password'] ?? '';
$pass2 = $_POST['confirm_password'] ?? '';

if ($email === '' || $token === '' || $pass === '' || $pass2 === '') {
  $_SESSION['flash_error'] = 'Please complete all fields.';
  header('Location: ' . BASE_URL . '/auth/login.php');
  exit;
}
if ($pass !== $pass2) {
  $_SESSION['flash_error'] = 'Passwords do not match.';
  header('Location: ' . BASE_URL . '/auth/reset.php?email='.urlencode($email).'&token='.urlencode($token));
  exit;
}
if (strlen($pass) < 8) {
  $_SESSION['flash_error'] = 'Password must be at least 8 characters.';
  header('Location: ' . BASE_URL . '/auth/reset.php?email='.urlencode($email).'&token='.urlencode($token));
  exit;
}

$tokenHash = hash_token($token);

$stmt = $conn->prepare("
  SELECT id, reset_token_expires_at
  FROM users
  WHERE email = ? AND reset_token_hash = ?
  LIMIT 1
");
$stmt->bind_param("ss", $email, $tokenHash);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
  $_SESSION['flash_error'] = 'Reset link is invalid or already used.';
  header('Location: ' . BASE_URL . '/auth/login.php');
  exit;
}

if (!empty($user['reset_token_expires_at']) && strtotime($user['reset_token_expires_at']) < time()) {
  $_SESSION['flash_error'] = 'Reset link expired. Please request again.';
  header('Location: ' . BASE_URL . '/auth/forgot.php');
  exit;
}

$hash = password_hash($pass, PASSWORD_BCRYPT);

$upd = $conn->prepare("
  UPDATE users
  SET password_hash = ?, reset_token_hash = NULL, reset_token_expires_at = NULL
  WHERE id = ?
");
$upd->bind_param("si", $hash, $user['id']);
$upd->execute();

$_SESSION['flash_success'] = 'Password updated. You can log in now.';
header('Location: ' . BASE_URL . '/auth/login.php');
exit;