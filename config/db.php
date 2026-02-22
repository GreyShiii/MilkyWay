<?php 
$servername = "localhost";
$username = "root";
$password = "";
$database = "MilkyWay";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database error: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>