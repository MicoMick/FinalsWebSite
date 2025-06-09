<?php
include 'db.php';

$name = 'supaAdmin';
$email = 'supaAdmin@nu-dasma.edu.ph';
$password = password_hash('supa@dmin123', PASSWORD_DEFAULT);
$role = 'super_admin';

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    echo "Superadmin created!";
} else {
    echo "Error: " . $conn->error;
}
?>
