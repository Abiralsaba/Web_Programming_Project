<?php
session_start();
require 'php with db class/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$apps = $conn->query("
    SELECT a.status, a.score, a.applied_at, j.title, j.company, j.location
    FROM applications a 
    JOIN jobs j ON a.job_id = j.id 
    WHERE a.user_id = $user_id 
    ORDER BY a.applied_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Applications - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/dashboard.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link">Browse Jobs</a>
        <a href="my-applications.php" class="nav-link nav-active">My Applications</a>
        <a href="logout.php" class="nav-link">Logout</a>
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5" style="max-width: 800px;">
    <h1 class="mb-3">My Applications</h1>
    <div class="glass-card-static slide-up">
      <?php while($row = $apps->fetch_assoc()): ?>
      <div class="app-row" style="margin-bottom:15px; border-bottom:1px solid rgba(0,0,0,0.05); padding-bottom:15px;">
        <div>
          <h3 class="mb-1"><?php echo htmlspecialchars($row['title']); ?></h3>
          <p class="text-muted text-sm"><?php echo htmlspecialchars($row['company']); ?> · <?php echo htmlspecialchars($row['location']); ?></p>
          <p class="text-muted text-xs mt-1">Applied: <?php echo date('M d, Y', strtotime($row['applied_at'])); ?></p>
        </div>
        <div class="text-right">
          <span class="badge badge-info mb-1" style="display:inline-block;"><?php echo ucfirst(htmlspecialchars($row['status'])); ?></span><br>
          <?php if($row['score']): ?>
          <p class="text-muted text-xs">Exam Score: <?php echo $row['score']; ?>%</p>
          <?php endif; ?>
        </div>
      </div>
      <?php endwhile; ?>
      <?php if($apps->num_rows == 0) echo "<p class='text-muted text-center py-4'>You haven't applied to any jobs yet.</p>"; ?>
    </div>
  </main>

  <script src="JS/script.js"></script>
</body>
</html>
