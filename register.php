<?php
session_start();
require 'php with db class/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['name'] = $first_name;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MAMA-KHALU.COM</title>
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
      <h2 class="mb-1 text-center">Sign Up</h2>
      <p class="text-muted text-center mb-4">Create your account</p>

      <?php if(isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label">First Name</label>
          <input type="text" name="first_name" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Last Name</label>
          <input type="text" name="last_name" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" required>
        </div>
        <button type="submit" class="btn btn-primary w-full">Sign Up</button>
      </form>

      <p class="text-center mt-3 text-muted text-sm">
        Already have an account? <a href="login.php" class="text-primary font-medium">Sign in</a>
      </p>
    </div>
  </div>

  <script src="JS/script.js"></script>
</body>
</html>
