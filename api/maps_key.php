<?php
require_once __DIR__ . '/../helpers/config.php';

header('Content-Type: application/json; charset=utf-8');

$key = config('GOOGLE_MAPS_KEY');
if (!$key) {
  http_response_code(500);
  echo json_encode(['error' => 'Maps key not configured']);
  exit;
}

echo json_encode(['key' => $key]);
