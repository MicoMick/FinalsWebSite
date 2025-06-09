<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'sample';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset for better international support
$conn->set_charset("utf8mb4");
?>
