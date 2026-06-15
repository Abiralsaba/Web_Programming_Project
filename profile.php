<?php
session_start();
require 'php with db class/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = $conn->query("SELECT * FROM users WHERE id = $user_id");
$user = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    
    $conn->query("UPDATE users SET first_name = '$first_name', last_name = '$last_name' WHERE id = $user_id");
    $_SESSION['name'] = $first_name . ' ' . $last_name;
    header("Location: profile.php?success=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link">Browse Jobs</a>
        <a href="logout.php" class="nav-link">Logout</a>
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5" style="max-width: 600px;">
    <div class="glass-card slide-up">
      <h2 class="mb-3">Complete Your Profile</h2>
      
      <?php if(isset($_GET['success'])): ?>
        <div class="badge badge-success mb-3 p-2" style="display:block;">Profile updated successfully!</div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group mb-3">
          <label class="form-label">First Name</label>
          <input type="text" name="first_name" class="form-input" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" name="last_name" class="form-input" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Email (Cannot be changed)</label>
          <input type="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
        </div>
        <button type="submit" class="btn btn-primary w-full mt-3">Save Profile</button>
      </form>
    </div>
  </main>

</body>
</html>
