<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!str_contains($email, "@nu-dasma.edu.ph")) {
        die("Invalid email domain.");
    }
        if (strlen($password) < 7) {
        die("Password must be at least 7 characters long.");
    }

    $stmt = $conn->prepare("SELECT id, name, email, password, role, org_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $row['role'];
            $_SESSION['user_org_id'] = $row['org_id']; // Important!

            if ($row['role'] === 'super_admin') {
                header("Location: superAdmin.html");
            } else if ($row['role'] === 'org_leader') {
                if (!empty($row['org_id'])) {
                    header("Location: sampleOrg.html?id=" . $row['org_id']);
                } else {
                    echo "Error: No organization assigned to this org leader.";
                }
            } else {
                header("Location: orgMain.html");
            }

            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
}
?>
