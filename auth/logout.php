<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../helpers/auth.php';
unset($_SESSION['visit_registered']);
auth_logout();
header("Location: " . BASE_URL . "/auth/login.php");
exit;