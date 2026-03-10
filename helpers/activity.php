<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/auth.php';

function log_login_activity(mysqli $conn, int $userId): void
{
    if ($userId <= 0) {
        return;
    }

    $update = $conn->prepare("
        UPDATE users
        SET last_login = NOW(),
            last_active_at = NOW(),
            login_count = login_count + 1
        WHERE id = ?
    ");
    $update->bind_param("i", $userId);
    $update->execute();
    $update->close();

    $label = 'User logged in';

    $insert = $conn->prepare("
        INSERT INTO user_activity_logs (user_id, activity_type, activity_label, page_url)
        VALUES (?, 'login', ?, NULL)
    ");
    $insert->bind_param("is", $userId, $label);
    $insert->execute();
    $insert->close();
}

function log_page_visit(mysqli $conn, int $userId, string $label, string $pageUrl): void
{
    if ($userId <= 0) {
        return;
    }

    $update = $conn->prepare("
        UPDATE users
        SET last_active_at = NOW()
        WHERE id = ?
    ");
    $update->bind_param("i", $userId);
    $update->execute();
    $update->close();

    $insert = $conn->prepare("
        INSERT INTO user_activity_logs (user_id, activity_type, activity_label, page_url)
        VALUES (?, 'view_page', ?, ?)
    ");
    $insert->bind_param("iss", $userId, $label, $pageUrl);
    $insert->execute();
    $insert->close();
}

function register_website_visit(mysqli $conn, int $userId): void
{
    if ($userId <= 0) {
        return;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['visit_registered'])) {
        $stmt = $conn->prepare("
            UPDATE users
            SET visit_count = visit_count + 1
            WHERE id = ?
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        $_SESSION['visit_registered'] = true;
    }
}