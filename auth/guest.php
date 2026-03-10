<?php
// simple endpoint that marks the session as a guest visit and redirects to home
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/session.php';

// clear any logged in state just in case and set guest flag
unset($_SESSION['user_id']);
$_SESSION['guest'] = true;

// inform the visitor they are browsing as guest (optional)
$_SESSION['flash_ok'] = "You are now browsing as a guest.";

// you might want to show a notice that you're browsing as guest, but it's
// optional – they can always log in later.
header("Location: " . BASE_URL . "/index.php?page=home");
exit;