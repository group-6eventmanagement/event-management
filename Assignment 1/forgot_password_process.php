<?php
require 'event_registration_system.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        echo "<p style='color:red;'>Enter your email</p>";
        echo "<p><a href='forgot-password.php'>Back</a></p>";
        exit;
    }
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        echo "<p style='color:green;'>A password reset link has been sent (simulated).</p>";
        echo "<p><a href='login.php'>Back to login</a></p>";
    } else {
        echo "<p style='color:red;'>Email not found</p>";
        echo "<p><a href='register.php'>Register</a></p>";
    }
    $stmt->close();
} else {
    header("Location: forgot-password.php");
    exit;
}
?>
