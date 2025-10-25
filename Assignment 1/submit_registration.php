<?php
require 'event_registration_system.php';
require 'EmailSimulator.php';

// Initialize email simulator
$emailSimulator = new EmailSimulator($conn);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (isset($_POST['type']) && $_POST['type'] === 'contact') {
    // Handle contact form
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        echo "<p style='color:red;'>Name, email and message are required.</p>";
        echo "<p><a href='contact.php'>Back</a></p>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $email, $phone, $message);
    if ($stmt->execute()) {
        $message_id = $stmt->insert_id;
        
        // Send acknowledgment email
        $emailSimulator->sendContactAcknowledgment([
            'id' => $message_id,
            'name' => $name,
            'email' => $email,
            'message' => $message
        ]);
        
        echo "<p style='color:green;'>Message sent. We'll reach out soon. A confirmation email has been sent.</p>";
        echo "<p><a href='index.php'>Back to home</a></p>";
    } else {
        echo "<p style='color:red;'>Error sending message: " . htmlspecialchars($stmt->error) . "</p>";
        echo "<p><a href='contact.php'>Back</a></p>";
    }
    $stmt->close();
    exit;
}

// Registration flow
$name = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$srn = trim($_POST['srn'] ?? '');
$password = $_POST['password'] ?? '';
$event_id = intval($_POST['event_id'] ?? 0);

if (empty($name) || empty($email) || empty($srn) || empty($password)) {
    echo "<p style='color:red;'>All fields are required!</p>";
    echo "<p><a href='register.php'>Back to register</a></p>";
    exit;
}

// Check if user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE srn = ?");
$stmt->bind_param('s', $srn);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "<p style='color:red;'>SRN already registered. Please login.</p>";
    echo "<p><a href='login.php'>Login</a></p>";
    $stmt->close();
    exit;
}
$stmt->close();

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt2 = $conn->prepare("INSERT INTO users (srn, password, fullname, email) VALUES (?, ?, ?, ?)");
$stmt2->bind_param('ssss', $srn, $hash, $name, $email);
if (!$stmt2->execute()) {
    echo "<p style='color:red;'>Error creating user: " . htmlspecialchars($stmt2->error) . "</p>";
    echo "<p><a href='register.php'>Back</a></p>";
    exit;
}
$user_id = $stmt2->insert_id;
$stmt2->close();

// Send registration confirmation email
$emailSimulator->sendRegistrationConfirmation([
    'id' => $user_id,
    'name' => $name,
    'email' => $email,
    'srn' => $srn
]);

// If event selected, add participant
if ($event_id > 0) {
    $phone = $srn;
    $stmt3 = $conn->prepare("INSERT INTO participants (event_id, fullname, email, phone) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param('isss', $event_id, $name, $email, $phone);
    if ($stmt3->execute()) {
        $participant_id = $stmt3->insert_id;
        
        // Get event details for confirmation email
        $eventStmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
        $eventStmt->bind_param('i', $event_id);
        $eventStmt->execute();
        $eventResult = $eventStmt->get_result();
        $event = $eventResult->fetch_assoc();
        $eventStmt->close();
        
        // Send event confirmation email
        if ($event) {
            $emailSimulator->sendEventConfirmation([
                'id' => $participant_id,
                'name' => $name,
                'email' => $email
            ], $event);
        }
        
        header("Location: index.php?registered=1");
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . htmlspecialchars($stmt3->error) . "</p>";
        echo "<p><a href='register.php'>Back to register</a></p>";
    }
    $stmt3->close();
} else {
    echo "<p style='color:green;'>Registration successful. You can now <a href='login.php'>login</a>.</p>";
}
?>