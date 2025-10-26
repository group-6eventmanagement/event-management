<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="contact">

  <header class="navbar">
    <a href="index.php" class="logo"><img src="css/js/images/logo.png" alt="Logo"></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
      <a href="contact.php" class="active">Contact</a>
    </nav>
  </header>

  <section class="contact-section">
    <div class="contact-header">
      <h3 class="campus-title">Campus Events</h3>
      <h1 class="contact-title">Contact Us</h1>
    </div>

    <div class="contact-container">
      <div class="contact-left">
        <h2>Online Inquiry</h2>
        <form method="POST" action="contact_process.php">
          <input type="text" name="name" placeholder="Full Name" required>
          <input type="email" name="email" placeholder="Email Address" required>
          <input type="tel" name="phone" placeholder="Phone Number" required>
          <textarea name="message" placeholder="Your Message" rows="4" required></textarea>
          <button type="submit">Send Message</button>
        </form>
      </div>

      <div class="contact-right">
        <h2>Contact Details</h2>
        <p><strong>Email:</strong> campusevents@easylife.com</p>
        <p><strong>Phone:</strong> +234 909 570 0091</p>
        <p><strong>Locations:</strong></p>
        <ul>
          <li>Nigeria – Lagos</li>
          <li>South Africa – Johannesburg</li>
          <li>United States – New York</li>
          <li>United Kingdom – London</li>
        </ul>
      </div>
    </div>
  </section>
</body>
</html>