<?php
session_start();
require 'event_registration_system.php';

// Optional: Only allow logged-in users (you can remove this if not needed)
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color:red;'>Access denied. Please <a href='login.php'>login</a>.</p>";
    exit;
}

// Fetch all participants
$sql = "SELECT p.id, p.fullname, p.email, p.phone, p.registered_at, e.event_name
        FROM participants p
        LEFT JOIN events e ON p.event_id = e.id
        ORDER BY p.registered_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Participants | Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #333;
      color: #fff;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .container {
      text-align: center;
      margin-top: 30px;
    }
    a {
      text-decoration: none;
      color: #007bff;
    }
  </style>
</head>
<body>
  <header class="navbar">
    <a href="index.php" class="logo"><img src="images/logo.png" alt="Logo"></a>
  </header>

  <div class="container">
    <h1>Registered Participants</h1>
    <?php if ($result && $result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone/SRN</th>
            <th>Event</th>
            <th>Registered At</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']); ?></td>
              <td><?php echo htmlspecialchars($row['fullname']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td><?php echo htmlspecialchars($row['event_name'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['registered_at']); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No participants found yet.</p>
    <?php endif; ?>
    <p><a href="index.php">← Back to Home</a></p>
  </div>
</body>
</html>
