<?php
require 'event_registration_system.php';
$event = isset($_GET['event']) ? intval($_GET['event']) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Event Details</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header class="navbar">
    <a href="index.php" class="logo"><img src="css/js/images/logo.png" alt="Logo"></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <section class="event-details">
    <h2>Annual Tech Conference 2025</h2>
    <img src="css/js/images/event1.jpg" alt="Tech Event" width="800">
    <p><strong>Date:</strong> November 10, 2025</p>
    <p><strong>Location:</strong> Excel London</p>
    <p>
      Join us for an exciting event filled with innovation, learning, and networking! 
      Experts in Artificial Intelligence and Cybersecurity will share valuable insights. 
    </p>
    <a href="register.php?event_id=<?php echo $event; ?>" class="btn">Register Now</a>
  </section>

  <footer>
    <p>&copy; 2025 Events. All rights reserved.</p>
  </footer>
</body>
</html>