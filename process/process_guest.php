<?php
session_start();
require_once __DIR__ . '/../helpers/function.php';

loginGuest();
header("Location: /MILKYWAY/index.php");
exit();
