<?php
session_start();

require_once __DIR__ . '/../public/config/db.php';

function requireUserOrGuest() {
  if (empty($_SESSION['user_id']) && empty($_SESSION['is_guest'])) {
    header("Location: /MILKYWAY/auth/auth.php");
    exit();
  }
}

function e($s){
  return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool {
  return !empty($_SESSION['user_id']);
}

function isGuest(): bool {
  return !empty($_SESSION['is_guest']);
}

function currentRole(): string {
  return $_SESSION['role'] ?? 'viewer';
}

function redirectIfAuthenticated(string $to = '/MILKYWAY/index.php'): void {
  if (isLoggedIn() || isGuest()) {
    header("Location: $to");
    exit();
  }
}


function requireAuth(string $to = '/MILKYWAY/auth/auth.php?mode=login'): void {
  if (!isLoggedIn() && !isGuest()) {
    header("Location: $to");
    exit();
  }
}

function registerValidation(string $username, string $email, string $password): ?string {
  if (trim($username) === '' || trim($email) === '' || trim($password) === '') {
    return "Please fill in all fields.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "Invalid email format.";
  }
  if (strlen($password) < 6) {
    return "Password must be at least 6 characters.";
  }
  return null;
}

function emailExists(string $email): bool {
  global $conn;

  $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $res = $stmt->get_result();
  $exists = $res && $res->fetch_assoc();
  $stmt->close();

  return (bool)$exists;
}

function createUser(string $username, string $email, string $passwordHash, string $role = 'viewer'): int {
  global $conn;

  $stmt = $conn->prepare("
    INSERT INTO users (username, email, password, role)
    VALUES (?, ?, ?, ?)
  ");
  $stmt->bind_param("ssss", $username, $email, $passwordHash, $role);
  $stmt->execute();

  $newId = $stmt->insert_id;
  $stmt->close();

  return (int)$newId;
}

function getUserByEmail(string $email): ?array {
  global $conn;

  $stmt = $conn->prepare("
    SELECT user_id, username, email, password, role
    FROM users
    WHERE email = ?
    LIMIT 1
  ");
  $stmt->bind_param("s", $email);
  $stmt->execute();

  $result = $stmt->get_result();
  $user = $result ? $result->fetch_assoc() : null;

  $stmt->close();
  return $user ?: null;
}

function loginUser(int $userId, string $role): void {
  unset($_SESSION['is_guest']);

  $_SESSION['user_id'] = $userId;
  $_SESSION['role'] = $role;
}

function loginGuest(): void {
  unset($_SESSION['user_id'], $_SESSION['role']);
  $_SESSION['is_guest'] = true;
}

function logout(): void {
  session_unset();
  session_destroy();
}

