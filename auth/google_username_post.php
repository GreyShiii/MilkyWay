<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/auth.php';

require_login();
csrf_verify();

$u = auth_user();
if (!$u) {
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

$username = trim($_POST['username'] ?? '');

if ($username === '') {
  $_SESSION['flash_err'] = "Username is required.";
  header("Location: " . BASE_URL . "/auth/google_username.php");
  exit;
}

if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
  $_SESSION['flash_err'] = "Username must be 3 to 20 characters and use only letters, numbers, or underscores.";
  header("Location: " . BASE_URL . "/auth/google_username.php");
  exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1");
$stmt->bind_param("si", $username, $u['id']);
$stmt->execute();
$exists = $stmt->get_result()->fetch_assoc();

if ($exists) {
  $_SESSION['flash_err'] = "That username is already taken.";
  header("Location: " . BASE_URL . "/auth/google_username.php");
  exit;
}

$stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
$stmt->bind_param("si", $username, $u['id']);

if (!$stmt->execute()) {
  $_SESSION['flash_err'] = "Unable to save username. Please try again.";
  header("Location: " . BASE_URL . "/auth/google_username.php");
  exit;
}

$_SESSION['username'] = $username;

header("Location: " . BASE_URL . "/index.php?page=home");
exit;