<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/activity.php';

require_guest();
csrf_verify();

$email = trim($_POST['email'] ?? '');
$pass  = $_POST['password'] ?? '';

if ($email === '' || $pass === '') {
  $_SESSION['flash_err'] = "Email and password are required.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

/* GET USER */
$stmt = $conn->prepare("
  SELECT id, username, email, password_hash, is_verified
  FROM users
  WHERE email = ?
  LIMIT 1
");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user || empty($user['password_hash'])) {
  $_SESSION['flash_err'] = "Invalid credentials.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

if (!password_verify($pass, $user['password_hash'])) {
  $_SESSION['flash_err'] = "Invalid credentials.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

if ((int)$user['is_verified'] !== 1) {
  $_SESSION['flash_err'] = "Please verify your email before logging in.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

auth_login((int)$user['id']);

$_SESSION['username'] = $user['username'];
$_SESSION['email']    = $user['email'];

log_login_activity($conn, (int)$user['id']);

header("Location: " . BASE_URL . "/index.php?page=home");
exit;
