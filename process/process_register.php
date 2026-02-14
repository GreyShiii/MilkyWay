<?php 
require_once __DIR__ . '/../helpers/function.php';

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

$error = registerValidation($username, $email, $password);
if ($error) {
    
    die($error);
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
createUser($username, $email, $passwordHash);

header("Location: ../auth/login.php");
exit();
?>
