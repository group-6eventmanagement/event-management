<?php
require 'event_registration_system.php';
if ($conn) {
    echo "✅ Database connection successful!";
} else {
    echo "❌ Connection failed!";
}
?>
