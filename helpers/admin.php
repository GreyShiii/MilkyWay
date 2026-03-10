<?php
require_once __DIR__ . '/auth.php';

function require_admin(): void
{
    require_login();

    $user = auth_user();

    if (!$user || !isset($user['role']) || $user['role'] !== 'admin') {
        http_response_code(403);
        exit('Access denied. Admins only.');
    }
}