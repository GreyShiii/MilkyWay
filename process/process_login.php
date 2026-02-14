<?php
session_start();
require_once __DIR__ . '/../helpers/function.php';

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$user = getUserByEmail($email);

if (!$user || !password_verify($password, $user['password'])) {
  $_SESSION['auth_error'] = "Invalid email or password.";
  header("Location: /MILKYWAY/auth/auth.php?mode=login");
  exit();
}

loginUser((int)$user['user_id'], $user['role']);
header("Location: /MILKYWAY/index.php");
exit();
