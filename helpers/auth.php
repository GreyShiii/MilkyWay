<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';

function require_login(): void {
  if (empty($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
  }
}

function require_guest(): void {
  if (!empty($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/index.php?page=home");
    exit;
  }
}

function auth_login(int $userId): void {
  $_SESSION['user_id'] = $userId;
}

function auth_logout(): void {
  unset($_SESSION['user_id']);
  session_destroy();
}

function auth_user(): ?array {
  if (empty($_SESSION['user_id'])) {
    return null;
  }
  $id = (int) $_SESSION['user_id'];

  global $conn;
  if (!isset($conn)) {
    require_once __DIR__ . '/../config/db.php';
  }

  $stmt = $conn->prepare("SELECT id, username, email, role, is_verified, google_id FROM users WHERE id = ? LIMIT 1");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();

  return $user ?: null;
}