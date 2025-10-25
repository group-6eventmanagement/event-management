<?php
require 'event_registration_system.php';
$pre_event = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-body">
  <header class="navbar">
    <a href="index.php" class="logo"><img src="images/logo.png" alt="Logo"></a>
  </header>

  <main class="container">
    <h1>Event Registration</h1>
    <form action="submit_registration.php" method="post">
      <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($pre_event); ?>">
      <label>Full name</label><br>
      <input type="text" name="fullname" required><br>
      <label>Email</label><br>
      <input type="email" name="email" required><br>
      <label>SRN</label><br>
      <input type="text" name="srn" required><br>
      <label>Password</label><br>
      <input type="password" name="password" required><br>
      <br>
      <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login here</a></p>
  </main>
</body>
</html>
