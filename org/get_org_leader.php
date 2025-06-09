<?php
include 'db.php';

if (isset($_GET['org_id'])) {
    $orgId = $_GET['org_id'];

    // Fetch user with role 'org_leader' for the specified org
    $stmt = $conn->prepare("SELECT name, email FROM users WHERE org_id = ? AND role = 'org_leader' LIMIT 1");
    $stmt->bind_param("i", $orgId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No leader found"]);
    }
} else {
    echo json_encode(["error" => "Missing org_id"]);
}
?>
