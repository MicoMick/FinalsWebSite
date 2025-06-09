<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['org_id'])) {
    echo json_encode(['error' => 'Organization ID is required']);
    exit;
}

$orgId = intval($_GET['org_id']);

$stmt = $conn->prepare("
    SELECT id, student_name, program 
    FROM applications 
    WHERE org_id = ? AND status = 'accepted'
    ORDER BY student_name ASC
");

if ($stmt === false) {
    echo json_encode(['error' => 'Failed to prepare statement']);
    exit;
}

$stmt->bind_param("i", $orgId);
$stmt->execute();
$result = $stmt->get_result();

$acceptedMembers = [];
while ($row = $result->fetch_assoc()) {
    $acceptedMembers[] = $row;
}

echo json_encode($acceptedMembers);
$stmt->close();
$conn->close();
?>
