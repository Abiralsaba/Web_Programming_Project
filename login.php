<?php
session_start();
require 'php with db class/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, first_name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['first_name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid";
        }
    } else {
        $error = "Invalid";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/login.css">
</head>
<body class="login-body">

  <div class="login-left">
    <a href="index.php" class="logo mb-5">MAMA<span>KHALU</span></a>
    <h1 class="login-heading mb-4">Welcome to the<br>Future of Hiring</h1>
    <ul class="login-features">
      <li class="mb-3"><span class="login-check">✓</span> AI-Powered Skill Matching</li>
      <li class="mb-3"><span class="login-check">✓</span> Instant Exam Results</li>
      <li class="mb-3"><span class="login-check">✓</span> Personalized Career Paths</li>
      <li class="mb-3"><span class="login-check">✓</span> 24/7 Course Access</li>
    </ul>
  </div>

  <div class="login-right">
    <div class="login-decor-1"></div>
    <div class="login-decor-2"></div>

    <div class="glass-card-static fade-in login-card">
      <h2 class="mb-1 text-center">Sign In</h2>
      <p class="text-muted text-center mb-4">Enter your credentials to access your account</p>

      <?php if(isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <input type="email" name="email" id="email" class="form-input" placeholder="you@example.com" required>
        </div>

        <div class="form-group">
          <div class="flex-between mb-1">
            <label class="form-label" for="password" style="margin-bottom:0;">Password</label>
            <a href="#" class="text-primary login-forgot">Forgot password?</a>
          </div>
          <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-primary w-full">Sign In</button>
      </form>

      <p class="text-center mt-3 text-muted text-sm">
        Don't have an account? <a href="register.php" class="text-primary font-medium">Sign up</a>
      </p>
    </div>
  </div>

  <script src="JS/script.js"></script>
</body>
</html>
