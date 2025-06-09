<?php
include 'db.php';

$org_id = $_GET['org_id'];
$result = $conn->query("SELECT * FROM applications WHERE org_id = $org_id AND status = 'pending'");

$applications = [];
while ($row = $result->fetch_assoc()) {
    $applications[] = $row;
}

echo json_encode($applications);
?>
