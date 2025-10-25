<?php
$event = isset($_GET['event']) ? intval($_GET['event']) : 1;
require 'event_registration_system.php';
$stmt = $conn->prepare("SELECT id, name, date, location FROM events WHERE id = ?");
$stmt->bind_param("i", $event);
$stmt->execute();
$result = $stmt->get_result();
$ev = $result->fetch_assoc();
$stmt->close();
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
    <a href="index.php" class="logo"><img src="images/logo.png" alt="Logo"></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <section class="event-details">
    <h2><?php echo htmlspecialchars($ev['name'] ?? 'Event'); ?></h2>
    <img src="images/event<?php echo $event; ?>.jpg" alt="Event Image" width="800">
    <p><strong>Date:</strong> <?php echo htmlspecialchars($ev['date'] ?? 'TBA'); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($ev['location'] ?? 'TBA'); ?></p>
    <p>
      Join us for an exciting event filled with innovation, learning, and networking.
    </p>
    <a href="register.php?event_id=<?php echo $event; ?>" class="btn">Register Now</a>
  </section>

  <footer>
    <p>&copy; 2025 Events. All rights reserved.</p>
  </footer>
</body>
</html>
