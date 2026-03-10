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

$sessionId = (int) ($_POST['session_id'] ?? 0);

if ($sessionId <= 0) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid session ID.'
    ]);
    exit;
}

$ok = bf_delete_session_by_id($sessionId, (int) $user['id']);

if (!$ok) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete session.'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Session deleted successfully.'
]);
exit;