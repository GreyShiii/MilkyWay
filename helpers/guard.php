<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function requireLogin() {
  if (!isset($_SESSION['user_id']) && !isset($_SESSION['is_guest'])) {
    header("Location: /MILKYWAY/auth/auth.php?mode=login");
    exit();
  }
}

function requireEditorOrAdmin() {
  if (!isset($_SESSION['user_id'])) {
    header("Location: /MILKYWAY/auth/auth.php?mode=login");
    exit();
  }
  $role = $_SESSION['role'] ?? 'viewer';
  if (!in_array($role, ['admin', 'editor'])) {
    die("Access denied.");
  }
}

function requireAdmin() {
  if (!isset($_SESSION['user_id'])) {
    header("Location: /MILKYWAY/auth/auth.php?mode=login");
    exit();
  }
  $role = $_SESSION['role'] ?? 'viewer';
  if ($role !== 'admin') {
    die("Access denied.");
  }
}
