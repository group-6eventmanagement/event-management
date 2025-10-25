<?php
require 'event_registration_system.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact | Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="navbar">
    <a href="index.php" class="logo"><img src="images/logo.png" alt="Logo"></a>
  </header>

  <main class="container">
    <h1>Contact us</h1>
    <form action="submit_registration.php" method="post">
      <input type="hidden" name="type" value="contact">
      <label>Name</label><br>
      <input type="text" name="name" required><br>
      <label>Email</label><br>
      <input type="email" name="email" required><br>
      <label>Phone</label><br>
      <input type="text" name="phone"><br>
      <label>Message</label><br>
      <textarea name="message" rows="5" required></textarea><br><br>
      <button type="submit">Send</button>
    </form>
  </main>
</body>
</html>
