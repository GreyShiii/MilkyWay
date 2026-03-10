<?php
require_once __DIR__ . '/../config/session.php';

function csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function csrf_input(): string {
  $t = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
  return '<input type="hidden" name="csrf_token" value="'.$t.'">';
}

function csrf_verify(): void {
  $sent = $_POST['csrf_token'] ?? '';
  $sess = $_SESSION['csrf_token'] ?? '';
  if (!$sent || !$sess || !hash_equals($sess, $sent)) {
    http_response_code(403);
    exit('Invalid CSRF token.');
  }
}