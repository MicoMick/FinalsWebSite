<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$userId = $data['userId'];

$stmt = $conn->prepare("UPDATE users SET role = 'user', org_id = NULL WHERE id = ?");
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo "User demoted to regular user.";
} else {
    echo "Demotion failed: " . $stmt->error;
}
?>
