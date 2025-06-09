<?php
require 'db.php'; // your connection setup

$sql = "SELECT id, org_name, tagline FROM org";
$result = $conn->query($sql);

$orgs = [];
while ($row = $result->fetch_assoc()) {
    $orgs[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orgs);
?>
