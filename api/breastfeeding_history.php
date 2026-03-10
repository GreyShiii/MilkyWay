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

$sessions = bf_get_sessions_by_user((int) $user['id']);

echo json_encode([
    'success' => true,
    'sessions' => $sessions
]);
exit;