<?php
session_start();

require_once __DIR__ . '/../helpers/function.php';

$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    die("Please fill in all fields.");
}

$user = getUserByEmail($email);

if (!$user) {
    die("Invalid email or password.");
}

if (!password_verify($password, $user['password_hash'])) {
    die("Invalid email or password.");
}

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

header("Location: ../index.php");
exit();
