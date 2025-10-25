<?php
// Central DB connection for the event registration system.
// Edit `config.php` to set your own credentials, or the defaults below will be used.

if (file_exists(__DIR__ . '/config.php')) {
   require_once __DIR__ . '/config.php';
} else {
    // Defaults (common XAMPP/LAMP default)
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'event_registration_system';
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $msg = $conn->connect_error;
    if (stripos($msg, 'access denied') !== false) {
        die('Database connection failed: Access denied. Check your MySQL username/password in config.php or set the user to one that exists. If using XAMPP, default is user: root with empty password.');
    } else if (stripos($msg, 'unknown database') !== false) {
        die('Database connection failed: Unknown database "' . htmlspecialchars($dbname) . '". Create the database or update config.php.');
    } else {
        die('Database connection failed: ' . htmlspecialchars($msg));
    }
}

$conn->set_charset("utf8mb4");
?>