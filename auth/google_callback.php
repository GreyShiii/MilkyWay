<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../config/session.php';

$cfg = require __DIR__ . '/../config/env.php';

$code  = $_GET['code'] ?? '';
$state = $_GET['state'] ?? '';

if (
  !$code ||
  !$state ||
  empty($_SESSION['google_oauth_state']) ||
  !hash_equals($_SESSION['google_oauth_state'], $state)
) {
  $_SESSION['flash_err'] = "Google login failed (invalid state).";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}
unset($_SESSION['google_oauth_state']);

$tokenRes = http_post('https://oauth2.googleapis.com/token', [
  'code' => $code,
  'client_id' => $cfg['GOOGLE_CLIENT_ID'],
  'client_secret' => $cfg['GOOGLE_CLIENT_SECRET'],
  'redirect_uri' => $cfg['GOOGLE_REDIRECT_URI'],
  'grant_type' => 'authorization_code',
]);

if (!$tokenRes || empty($tokenRes['access_token'])) {
  $_SESSION['flash_err'] = "Google login failed (token).";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

$accessToken = $tokenRes['access_token'];

$userInfo = http_get_json('https://www.googleapis.com/oauth2/v2/userinfo', $accessToken);

if (!$userInfo || empty($userInfo['email']) || empty($userInfo['id'])) {
  $_SESSION['flash_err'] = "Google login failed (profile).";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

$googleId = (string)$userInfo['id'];
$email    = trim((string)$userInfo['email']);

// find existing by email
$stmt = $conn->prepare("SELECT id, google_id, username FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$existing = $stmt->get_result()->fetch_assoc();

if ($existing) {
  if (empty($existing['google_id'])) {
    $stmt = $conn->prepare("UPDATE users SET google_id = ?, is_verified = 1 WHERE id = ?");
    $stmt->bind_param("si", $googleId, $existing['id']);
    $stmt->execute();
  }

  auth_login((int)$existing['id']);
  $_SESSION['username'] = $existing['username'] ?? '';

  $stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
  $stmt->bind_param("i", $existing['id']);
  $stmt->execute();

  if (empty($existing['username']) || strpos($existing['username'], 'googleuser_') === 0) {
    $_SESSION['flash_ok'] = "Choose a username to continue.";
    header("Location: " . BASE_URL . "/auth/google_username.php");
    exit;
  }

  header("Location: " . BASE_URL . "/index.php?page=home");
  exit;
}

$tempUsername = 'googleuser_' . bin2hex(random_bytes(4));

$stmt = $conn->prepare("
  INSERT INTO users (username, email, password_hash, google_id, role, is_verified, verification_token)
  VALUES (?, ?, NULL, ?, 'user', 1, NULL)
");
$stmt->bind_param("sss", $tempUsername, $email, $googleId);

if (!$stmt->execute()) {
  $_SESSION['flash_err'] = "Google signup failed. Try again.";
  header("Location: " . BASE_URL . "/auth/login.php");
  exit;
}

$newId = (int)$conn->insert_id;

auth_login($newId);
$_SESSION['username'] = $tempUsername;

$stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
$stmt->bind_param("i", $newId);
$stmt->execute();

$_SESSION['flash_ok'] = "Choose a username to continue.";
header("Location: " . BASE_URL . "/auth/google_username.php");
exit;

function http_post(string $url, array $data): ?array {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data),
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
  ]);
  $out = curl_exec($ch);
  $err = curl_error($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($out === false || $err || $code >= 400) return null;

  $json = json_decode($out, true);
  return is_array($json) ? $json : null;
}

function http_get_json(string $url, string $accessToken): ?array {
  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ["Authorization: Bearer {$accessToken}"],
  ]);
  $out = curl_exec($ch);
  $err = curl_error($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($out === false || $err || $code >= 400) return null;

  $json = json_decode($out, true);
  return is_array($json) ? $json : null;
}