<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Campus Events</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-body">
  <header class="navbar">
  </header>

  <main class="container">
    <h1>Login</h1>
    <form action="login_process.php" method="POST">
      <label>Matric number</label><br>
      <input type="text" name="srn" required><br>

      <label>Password</label><br>
      <input type="password" name="password" required><br><br>

      <button type="submit">Login</button>
    </form>

    <p>Don’t have an account? <a href="register.php">Register here</a></p>
  </main>
</body>
</html>
