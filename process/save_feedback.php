<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!is_array($data)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid JSON']);
  exit;
}

$rating = (int)($data['rating'] ?? 0);
$liked = $data['liked'] ?? [];
if (!is_array($liked)) $liked = [];

if ($rating < 1 || $rating > 5) {
  http_response_code(422);
  echo json_encode(['ok' => false, 'error' => 'Rating must be 1-5']);
  exit;
}

$liked_design  = in_array('design', $liked, true) ? 1 : 0;
$liked_content = in_array('content', $liked, true) ? 1 : 0;
$liked_easy    = in_array('easy', $liked, true) ? 1 : 0;
$liked_tips    = in_array('tips', $liked, true) ? 1 : 0;

$stmt = $conn->prepare("
  INSERT INTO feedback (rating, liked_design, liked_content, liked_easy, liked_tips)
  VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Prepare failed']);
  exit;
}

$stmt->bind_param("iiiii", $rating, $liked_design, $liked_content, $liked_easy, $liked_tips);

if (!$stmt->execute()) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Insert failed']);
  exit;
}

echo json_encode(['ok' => true, 'id' => $stmt->insert_id]);
