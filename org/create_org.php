<?php
header('Content-Type: application/json');
include 'db.php'; // Your DB connection file

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['org_name']) || empty(trim($data['org_name']))) {
    echo json_encode(['success' => false, 'error' => 'Missing organization name']);
    exit;
}

$org_name = $conn->real_escape_string(trim($data['org_name']));

// Insert new org
$sql = "INSERT INTO org (org_name) VALUES ('$org_name')";
if ($conn->query($sql) === TRUE) {
    $newId = $conn->insert_id;
    echo json_encode(['success' => true, 'id' => $newId]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
