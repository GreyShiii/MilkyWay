<?php
session_start();
require_once __DIR__ . '/../helpers/lang.php';

$code = $_POST['lang'] ?? 'en';
set_lang($code);

$back = $_SERVER['HTTP_REFERER'] ?? '/MILKYWAY/index.php?page=home';
header("Location: " . $back);
exit;
