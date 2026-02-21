<?php
function config($key, $default = null) {
  static $cfg = null;
  if ($cfg === null) $cfg = require __DIR__ . '/../config/env.php';
  return $cfg[$key] ?? $default;
}
