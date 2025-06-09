<?php
$pdo = new PDO("mysql:host=localhost;dbname=sample", "root", "");
$data = json_decode(file_get_contents("php://input"), true);

// Extract data
$id = $data['id'] ?? '';
$name = $data['org_name'] ?? '';
$tagline = $data['tagline'] ?? '';
$mission = $data['mission'] ?? '';
$vision = $data['vision'] ?? '';
$background = $data['background'] ?? '';
$goals = $data['goals'] ?? '';

// Validate essential fields
if (!$id || !$name) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing required fields']);
  exit;
}

// Update org table
$stmt = $pdo->prepare("UPDATE org SET org_name = ?, tagline = ?, mission = ?, vision = ?, background = ?, goals = ? WHERE id = ?");
$success = $stmt->execute([$name, $tagline, $mission, $vision, $background, $goals, $id]);

if ($success) {
  echo json_encode(['success' => true]);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Update failed']);
}
?>