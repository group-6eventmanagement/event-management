<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="forgot-page">
  <header class="navbar">
    <a href="index.php" class="logo"><img src="css/js/images/logo.png" alt="Logo"></a>
    <nav>
      <a href="index.php">Home</a>
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
      <a href="contact.php">Contact</a>
    </nav>
  </header>

  <div class="forgot-container">
    <h2>Forgot Password?</h2>
    <p>Enter your email address to reset your password.</p>
    <form method="POST" action="forgot_password_process.php">
      <input type="email" name="email" placeholder="Enter Email Address" required>
      <button type="submit">Reset Password</button>
      <a href="login.php" class="back-link">← Back to Login</a>
    </form>
  </div>
</body>
</html>