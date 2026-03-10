<?php
function make_token(int $bytes = 32): string {
  return rtrim(strtr(base64_encode(random_bytes($bytes)), '+/', '-_'), '=');
}

function hash_token(string $token): string {
  return hash('sha256', $token);
}

function now_mysql(): string {
  return date('Y-m-d H:i:s');
}

function add_hours_mysql(int $hours): string {
  return date('Y-m-d H:i:s', time() + ($hours * 3600));
}

function add_minutes_mysql(int $minutes): string {
  return date('Y-m-d H:i:s', time() + ($minutes * 60));
}