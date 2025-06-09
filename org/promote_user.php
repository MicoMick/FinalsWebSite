<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$userId = $data['userId'];
$orgId = $data['orgId'];

$stmt = $conn->prepare("UPDATE users SET role = 'org_leader', org_id = ? WHERE id = ?");
$stmt->bind_param("ii", $orgId, $userId);

if ($stmt->execute()) {
    echo "User promoted to org leader!";
} else {
    echo "Promotion failed: " . $stmt->error;
}
?>
