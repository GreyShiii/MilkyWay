<?php
require_once __DIR__ . '/../config/db.php';

function bf_get_sessions_by_user(int $userId): array {
    global $conn;

    $sql = "SELECT id, user_id, started_at, ended_at, duration_seconds, created_at
            FROM breastfeeding_sessions
            WHERE user_id = ?
            ORDER BY started_at DESC, id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    $result = $stmt->get_result();
    $sessions = [];

    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }

    $stmt->close();
    return $sessions;
}

function bf_add_session(int $userId, string $startedAt, string $endedAt, int $durationSeconds): bool {
    global $conn;

    $sql = "INSERT INTO breastfeeding_sessions (user_id, started_at, ended_at, duration_seconds)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $userId, $startedAt, $endedAt, $durationSeconds);
    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
}

function bf_clear_sessions_by_user(int $userId): bool {
    global $conn;

    $sql = "DELETE FROM breastfeeding_sessions WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
}

function bf_delete_session_by_id(int $sessionId, int $userId): bool {
    global $conn;

    $sql = "DELETE FROM breastfeeding_sessions WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $sessionId, $userId);
    $ok = $stmt->execute();
    $stmt->close();

    return $ok;
}