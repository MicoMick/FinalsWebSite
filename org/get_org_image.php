<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$conn = new mysqli("localhost", "root", "", "sample");
if ($conn->connect_error) {
    http_response_code(500);
    exit("DB connection failed");
}

$sql = "SELECT org_image FROM org WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($image);
    $stmt->fetch();

    if (!empty($image)) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($image) ?: 'image/png';
        header("Content-Type: $mimeType");
        header("Content-Length: " . strlen($image));
        echo $image;
    } else {
        // No image, serve fallback
        header("Content-Type: image/png");
        readfile("placeholder.png");
    }
} else {
    http_response_code(404);
    echo "Image not found.";
}

$stmt->close();
$conn->close();
?>
