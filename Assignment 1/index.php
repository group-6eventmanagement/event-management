<?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
  <p style="background: #d4edda; color: #155724; padding: 10px; text-align:center;">
    Registration successful!
  </p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="home">
  <header class="navbar">
    <a href="index.php" class="logo">
      <img src="css/js/images/logo.png" alt="Logo">
    </a>
    <nav>
      <a href="index.php" class="active">Home</a>
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to CampusEvent</h1>
      <p>Register for exciting events near you</p>
      <a href="register.php" class="btn">Get Started</a>
    </div>
  </section>

  <section class="search-section">
    <input type="text" id="search" placeholder="Search for events...">
    <select id="filter">
      <option value="all">All Categories</option>
      <option value="tech">Tech</option>
      <option value="music">Music</option>
      <option value="sports">Sports</option>
    </select>
  </section>

  <section class="events">
    <h2>Upcoming Events</h2>
    <div class="event-list" id="eventList">
      <div class="event-card" data-category="tech">
        <img src="css/js/images/event1.jpg" alt="Tech Event">
        <h3>Tech Innovation Summit</h3>
        <p>Date: Oct 25, 2025</p>
        <a href="event-details.php?event=1" class="btn">View Details</a>
      </div>

      <div class="event-card" data-category="music">
        <img src="css/js/images/event2.jpg" alt="Music Event">
        <h3>Campus Music Night</h3>
        <p>Date: Nov 2, 2025</p>
        <a href="event-details.php?event=2" class="btn">View Details</a>
      </div>

      <div class="event-card" data-category="sports">
        <img src="css/js/images/event3.jpg" alt="Sports Event">
        <h3>Interdepartmental Sports Festival</h3>
        <p>Date: Dec 5, 2025</p>
        <a href="event-details.php?event=3" class="btn">View Details</a>
      </div>

      <div class="event-card" data-category="art">
        <img src="css/js/images/event4.jpg" alt="Art Event">
        <h3>Art Auction</h3>
        <p>Date: Nov 12, 2025</p>
        <a href="event-details.php?event=4" class="btn">View Details</a>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 Campus Events </p>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>