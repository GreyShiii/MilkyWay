<?php
session_start();
session_unset();
session_destroy();
header("Location: /MILKYWAY/auth/auth.php");
exit();
?>
