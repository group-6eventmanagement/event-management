<?php
require 'event_registration_system.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = intval($_POST["event_id"] ?? 0);
    $fullname = trim($_POST["fullname"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $srn = trim($_POST["srn"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($fullname) || empty($email) || empty($srn) || empty($password)) {
        echo "<p style='color:red;'>All fields are required.</p>";
        echo "<a href='register.php'>Back</a>";
        exit;
    }

    // insert into users table if new user
    $stmt = $conn->prepare("INSERT INTO users (srn, password, fullname, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $srn, $password, $fullname, $email);
    $stmt->execute();
    $stmt->close();

    // also register them for the event if event_id exists
    if ($event_id > 0) {
        $stmt2 = $conn->prepare("INSERT INTO participants (event_id, fullname, email, phone) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("isss", $event_id, $fullname, $email, $srn);
        $stmt2->execute();
        $stmt2->close();
    }

    header("Location: index.php?registered=1");
    exit;
}
?>
