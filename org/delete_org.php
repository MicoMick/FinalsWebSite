<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$orgId = $data['orgId'] ?? null;

if ($orgId) {
    // Optional: Unassign users linked to this org first if needed
    $conn->query("UPDATE users SET org_id = NULL WHERE org_id = $orgId");

    $stmt = $conn->prepare("DELETE FROM org WHERE id = ?");
    $stmt->bind_param("i", $orgId);

    if ($stmt->execute()) {
        echo "Organization deleted.";
    } else {
        echo "Failed to delete organization.";
    }
}
?>
