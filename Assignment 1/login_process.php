<?php
session_start();
require 'event_registration_system.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $srn = trim($_POST['srn'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($srn) || empty($password)) {
        echo "<p style='color:red;'>Fill all fields</p>";
        echo "<p><a href='login.php'>Back to login</a></p>";
        exit;
    }
    $stmt = $conn->prepare("SELECT id, password, fullname FROM users WHERE srn = ?");
    $stmt->bind_param("s", $srn);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['fullname'];
            header("Location: index.php");
            exit;
        } else {
            echo "<p style='color:red;'>Invalid credentials</p>";
            echo "<p><a href='login.php'>Back to login</a></p>";
        }
    } else {
        echo "<p style='color:red;'>No account found</p>";
        echo "<p><a href='register.php'>Register</a></p>";
    }
    $stmt->close();
} else {
    header("Location: login.php");
    exit;
}
?>
