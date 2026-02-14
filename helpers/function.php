<?php
require_once __DIR__ . '/../config/db.php';

function registerValidation($username, $email, $password) {
    if (empty($username) || empty($email) || empty($password)) {
        return "Please fill in all fields.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }

    if (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }

    return null;
}

function createUser($username, $email, $passwordHash) {
    global $conn;

    $stmt = $conn->prepare("
        INSERT INTO users (username, email, password_hash)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("sss", $username, $email, $passwordHash);
    $stmt->execute();
    $stmt->close();
}

function getUserByEmail($email) {
    global $conn;

    $stmt = $conn->prepare("
        SELECT user_id, username, email, password_hash, role
        FROM users
        WHERE email = ?
        LIMIT 1
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    return $user ?: null;
}
