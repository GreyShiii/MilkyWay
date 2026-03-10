<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/csrf.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/auth.php';

require_guest();

csrf_verify();

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$pass     = $_POST['password'] ?? '';
$confirm  = $_POST['confirm_password'] ?? '';

if ($username === '' || $email === '' || $pass === '' || $confirm === '') {
  $_SESSION['flash_err'] = "All fields are required.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['flash_err'] = "Invalid email format.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

if ($pass !== $confirm) {
  $_SESSION['flash_err'] = "Passwords do not match.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

if (strlen($pass) < 8) {
  $_SESSION['flash_err'] = "Password must be at least 8 characters.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
if ($stmt->get_result()->fetch_assoc()) {
  $_SESSION['flash_err'] = "Username is already taken.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->fetch_assoc()) {
  $_SESSION['flash_err'] = "Email is already registered.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

$hash = password_hash($pass, PASSWORD_BCRYPT);
$token = bin2hex(random_bytes(32));

$stmt = $conn->prepare("
  INSERT INTO users (username, email, password_hash, role, is_verified, verification_token)
  VALUES (?, ?, ?, 'user', 0, ?)
");
$stmt->bind_param("ssss", $username, $email, $hash, $token);

if (!$stmt->execute()) {
  $_SESSION['flash_err'] = "Registration failed. Please try again.";
  header("Location: " . BASE_URL . "/auth/register.php"); exit;
}

$cfg = require __DIR__ . '/../config/env.php';
$link = rtrim($cfg['APP_URL'], '/') . "/auth/verify.php?token=" . urlencode($token) . "&email=" . urlencode($email);

$subject = "Verify your MilkyWay account";
$html = "
  <div style='font-family:Arial,sans-serif;line-height:1.6'>
    <h2>Verify your email</h2>
    <p>Click the button below to verify your account (expires in 24 hours).</p>
    <p><a href='{$link}' style='display:inline-block;padding:12px 16px;background:#ff6f7a;color:#fff;text-decoration:none;border-radius:10px;font-weight:700'>Verify Email</a></p>
    <p>If you did not create this account, ignore this email.</p>
  </div>
";

$sent = send_email($email, $subject, $html);

if (!$sent) {
  $_SESSION['flash_err'] = "Account was created, but the verification email could not be sent. Please try resending it.";
  $_SESSION['verify_email'] = $email;
  header("Location: " . BASE_URL . "/auth/verify_notice.php");
  exit;
}

$_SESSION['verify_email'] = $email; 
$_SESSION['flash_ok'] = "Account created! Please verify your email to continue.";
header("Location: " . BASE_URL . "/auth/verify_notice.php");
exit;