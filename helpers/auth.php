<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';

function require_login(): void {
  // Allow either a logged-in user or a guest visitor. Guests are marked with
  // \$_SESSION['guest'] and do not have a user_id. This keeps the existing
  // behaviour (redirecting non-authenticated visitors to login) while
  // permitting anonymous browsing for most pages.
  if (empty($_SESSION['user_id']) && empty($_SESSION['guest'])) {
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
  // normal login clears any guest state and registers the user id
  unset($_SESSION['guest']);
  $_SESSION['user_id'] = $userId;
}

function auth_logout(): void {
  unset($_SESSION['user_id']);
  session_destroy();
}


/**
 * Returns true if the current session is a "guest" visit.
 */
function is_guest(): bool {
  return !empty($_SESSION['guest']) && empty($_SESSION['user_id']);
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