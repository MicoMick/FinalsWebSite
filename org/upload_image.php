<?php
if (!isset($_FILES['image']) || !isset($_POST['id'])) {
    http_response_code(400);
    exit("Missing image or ID");
}

$id = intval($_POST['id']);
$imageData = file_get_contents($_FILES['image']['tmp_name']);

$conn = new mysqli("localhost", "root", "", "sample");
if ($conn->connect_error) {
    http_response_code(500);
    exit("DB connection failed");
}

$sql = "UPDATE org SET org_image = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    exit("Prepare failed: " . $conn->error);
}

// Pass NULL first, then send actual data
$null = NULL;
$stmt->bind_param("bi", $null, $id);
$stmt->send_long_data(0, $imageData);

if ($stmt->execute()) {
    echo "Image uploaded successfully.";
} else {
    http_response_code(500);
    echo "Failed to update image: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
