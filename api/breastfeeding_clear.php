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

$ok = bf_clear_sessions_by_user((int) $user['id']);

if (!$ok) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to clear history.'
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'History cleared successfully.'
]);
exit;