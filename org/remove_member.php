<?php
require 'db.php'; // Use your existing db connection

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$org_id = $data['org_id'] ?? null;

if (!$id || !$org_id) {
    http_response_code(400);
    echo "Missing id or org_id";
    exit;
}

$stmt = $conn->prepare("DELETE FROM applications WHERE id = ? AND org_id = ? AND status = 'accepted'");
$stmt->bind_param("ii", $id, $org_id);

if ($stmt->execute()) {
    echo "Member removed successfully.";
} else {
    http_response_code(500);
    echo "Failed to remove member.";
}

$stmt->close();
$conn->close();
?>
