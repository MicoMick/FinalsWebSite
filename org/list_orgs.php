<?php
include 'db.php';

$sql = "SELECT o.id, o.org_name, u.name AS leader_name, u.email AS leader_email
        FROM org o
        LEFT JOIN users u ON o.id = u.org_id AND u.role = 'org_leader'";
$result = $conn->query($sql);

$orgs = [];
while ($row = $result->fetch_assoc()) {
    $orgs[] = $row;
}

echo json_encode($orgs);
?>
