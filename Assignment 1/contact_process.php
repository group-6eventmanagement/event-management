<?php
require 'event_registration_system.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($message)) {
        echo "<p style='color:red;'>Please fill all required fields.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);
        if ($stmt->execute()) {
            echo "<p>Message sent successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error sending message.</p>";
        }
        $stmt->close();
    }
}
?>
