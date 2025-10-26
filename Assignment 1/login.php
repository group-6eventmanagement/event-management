<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth">
  <header class="navbar">
    <a href="index.php" class="logo">
      <img src="css/js/images/logo.png" alt="Logo">
    </a>
    <nav>
      <a href="index.php">Home</a>
      <a href="register.php">Register</a>
      <a href="login.php" class="active">Login</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <div class="auth-container fade-in">
    <h2>Login to Enroll for Events</h2>
    
    <form method="POST" action="login_process.php">
      <label>Client SRN</label>
      <input type="text" name="srn" placeholder="Enter your SRN" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>

      <button type="submit" class="btn">Login</button>
    </form>
    <p>Don’t have an account? <a href="register.php">Register here</a></p>
    <p><a href="forgot_password_process.php">Forgot password?</a></p>
  </div>
</body>
</html>