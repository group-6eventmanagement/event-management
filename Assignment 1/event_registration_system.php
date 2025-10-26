<?php
// event_registration_system.php
// Central database connection file

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_system"; //  make sure this matches your SQL file name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>