<?php
require 'event_registration_system.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $srn = trim($_POST["srn"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM users WHERE srn = ?");
    $stmt->bind_param("s", $srn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        if ($password === $row["password"]) { // For demo; use password_hash() in real use
            echo "<p>Login successful. Welcome, " . htmlspecialchars($row["fullname"]) . "!</p>";
        } else {
            echo "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;'>SRN not found.</p>";
    }
    $stmt->close();
}
?>
