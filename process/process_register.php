<?php
session_start();
require_once __DIR__ . '/../helpers/function.php';

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$err = registerValidation($username, $email, $password);
if ($err) {
  $_SESSION['auth_error'] = $err;
  header("Location: /MILKYWAY/auth/auth.php?mode=register");
  exit();
}

if (emailExists($email)) {
  $_SESSION['auth_error'] = "Email already registered. Try logging in.";
  header("Location: /MILKYWAY/auth/auth.php?mode=login");
  exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$userId = createUser($username, $email, $hash, 'viewer');

// Option A: auto-login after signup:
loginUser($userId, 'viewer');
header("Location: /MILKYWAY/index.php");
exit();
