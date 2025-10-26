<?php
require 'event_registration_system.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        echo "<p>Password reset instructions have been sent to your email (demo message).</p>";
    } else {
        echo "<p style='color:red;'>No account found with that email.</p>";
    }
    $stmt->close();
}
?>
