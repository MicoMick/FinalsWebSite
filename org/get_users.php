<?php
include 'db.php';

// Exclude users with role 'super_admin'
$result = $conn->query("SELECT id, name, email, role FROM users WHERE role != 'super_admin'");
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>
