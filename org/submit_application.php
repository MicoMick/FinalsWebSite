<?php
include 'db.php';

if (
    isset($_POST['org_id']) &&
    isset($_POST['student_name']) &&
    isset($_POST['student_number']) &&
    isset($_POST['program']) &&
    isset($_POST['school_email'])
) {
    $org_id = intval($_POST['org_id']); // Ensure it's an integer
    $name = $_POST['student_name'];
    $number = $_POST['student_number'];
    $program = $_POST['program'];
    $email = $_POST['school_email'];

    // OPTIONAL: check if org_id exists before inserting
    $check = $conn->prepare("SELECT id FROM org WHERE id = ?");
    $check->bind_param("i", $org_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        echo "Invalid organization ID.";
        exit;
    }

    // Proceed with insert
    $stmt = $conn->prepare("INSERT INTO applications (org_id, student_name, student_number, program, school_email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $org_id, $name, $number, $program, $email);

    if ($stmt->execute()) {
        echo "Application submitted!";
    } else {
        echo "Error submitting application: " . $stmt->error;
    }
} else {
    echo "Missing form data!";
}
?>
