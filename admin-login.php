<?php
session_start();
require 'php with db class/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, first_name, role FROM users WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['first_name'];
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials";
        }
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/admin-login.css">
</head>
<body class="admin-login-body">

  <div class="admin-login-decor-top"></div>
  <div class="admin-login-decor-bottom"></div>

  <div class="glass-card animate-fade-in admin-login-card">
    <div class="text-center mb-4">
      <a href="index.php" class="logo flex-center mb-2 admin-logo-center">MAMA<span>KHALU</span></a>
      <div class="badge mb-2 admin-badge">Admin Portal</div>
    </div>
    
    <?php if(isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label class="form-label" for="email">Admin Email</label>
        <input type="email" name="email" id="email" class="form-input" placeholder="admin@mamakhalu.com" required>
      </div>
      
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
      </div>
      
      <button type="submit" class="btn btn-primary mt-2 admin-login-btn">Access Secure Portal</button>
    </form>
    
    <div class="text-center mt-4 pt-4 admin-back-link-container">
      <a href="login.php" class="text-light admin-back-link">← Back to Applicant Login</a>
    </div>
  </div>

</body>
</html>
