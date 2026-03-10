<?php
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/breastfeeding_crud.php';

header('Content-Type: application/json; charset=utf-8');

require_login();
$user = auth_user();

if (!$user || empty($user['id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    exit;
}

$startedAt = trim($_POST['started_at'] ?? '');
$endedAt = trim($_POST['ended_at'] ?? '');
$durationSeconds = (int) ($_POST['duration_seconds'] ?? 0);

if ($startedAt === '' || $endedAt === '' || $durationSeconds <= 0) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid session data.'
    ]);
    exit;
}

$ok = bf_add_session((int) $user['id'], $startedAt, $endedAt, $durationSeconds);

if (!$ok) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save session.'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Session saved successfully.'
]);
exit;