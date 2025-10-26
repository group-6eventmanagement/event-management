<?php
// register.php
require 'event_registration_system.php';
// if you want to pre-fill event_id from query string (when user clicks Register on event):
$pre_event = isset($_GET['event_id']) ? intval($_GET['event_id']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth">
  <header class="navbar">
    <a href="index.php" class="logo"><img src="css/js/images/logo.png" alt="Logo"></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="register.php" class="active">Register</a>
      <a href="login.php">Login</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <div class="auth-container fade-in">
    <h2>Register for Campus Events</h2>

    <!-- send data to submit_registration.php -->
    <form method="POST" action="submit_registration.php">
      <!-- if event_id supplied from link -->
      <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($pre_event); ?>">

      <label>Full Name</label>
      <input type="text" name="fullname" placeholder="Enter your name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>SRN</label>
      <input type="text" name="srn" placeholder="Enter your SRN" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Create password" required>

      <button type="submit" class="btn">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</body>
</html>