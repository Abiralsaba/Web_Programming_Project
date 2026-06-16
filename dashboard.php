<?php
session_start();
require 'php with db class/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];


$app_res = $conn->query("SELECT COUNT(*) as c FROM applications WHERE user_id = $user_id");
$total_apps = $app_res->fetch_assoc()['c'];

$exam_res = $conn->query("SELECT COUNT(*) as c FROM exam_results WHERE user_id = $user_id AND passed = 1");
$total_exams = $exam_res->fetch_assoc()['c'];


$recent_apps = $conn->query("
    SELECT a.status, a.score, j.title, j.company 
    FROM applications a 
    JOIN jobs j ON a.job_id = j.id 
    WHERE a.user_id = $user_id 
    ORDER BY a.applied_at DESC LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/dashboard.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link nav-active">Dashboard</a>
        <a href="jobs.php" class="nav-link">Browse Jobs</a>
        <a href="complaint.php" class="nav-link">Complaints</a>
        <a href="logout.php" class="nav-link">Logout</a>
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5">
    <header class="mb-4">
      <h1 class="mb-1">Welcome back, <span id="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>! 👋</h1>
      <p class="text-muted">Here's what's happening with your job search today.</p>
    </header>

    <!-- Stats -->
    <div class="dash-stats mb-4">
      <div class="glass-card slide-up">
        <p class="text-muted text-sm mb-1">Applications</p>
        <div class="flex-between">
          <span class="stat-val"><?php echo $total_apps; ?></span>
        </div>
      </div>
      <div class="glass-card slide-up" style="animation-delay:.1s">
        <p class="text-muted text-sm mb-1">Exams Passed</p>
        <div class="flex-between">
          <span class="stat-val"><?php echo $total_exams; ?></span>
        </div>
      </div>
      <div class="glass-card slide-up" style="animation-delay:.2s">
        <p class="text-muted text-sm mb-1">Active Courses</p>
        <div class="flex-between">
          <span class="stat-val">0</span>
        </div>
      </div>
      <div class="glass-card slide-up" style="animation-delay:.3s">
        <p class="text-muted text-sm mb-1">Exam Pass Rate</p>
        <div class="flex-between">
          <?php
            $taken_res = $conn->query("SELECT COUNT(*) as c FROM exam_results WHERE user_id = $user_id");
            $total_taken = $taken_res->fetch_assoc()['c'];
            $pass_rate = $total_taken > 0 ? round(($total_exams / $total_taken) * 100) : 0;
          ?>
          <span class="stat-val"><?php echo $pass_rate; ?>%</span>
        </div>
      </div>
    </div>

    <div class="grid-2">
      <!-- Recent Applications -->
      <div class="glass-card-static slide-up" style="animation-delay:.4s">
        <div class="flex-between mb-3">
          <h3>Recent Applications</h3>
          <a href="my-applications.php" class="text-primary text-sm">View All</a>
        </div>

        <?php while($row = $recent_apps->fetch_assoc()): ?>
        <div class="app-row">
          <div>
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <p class="text-muted text-sm"><?php echo htmlspecialchars($row['company']); ?></p>
          </div>
          <div class="text-right">
            <span class="badge badge-info"><?php echo ucfirst(htmlspecialchars($row['status'])); ?></span>
            <?php if($row['score']): ?>
            <p class="text-muted text-xs mt-1">Score: <?php echo $row['score']; ?>%</p>
            <?php endif; ?>
          </div>
        </div>
        <?php endwhile; ?>
        <?php if($recent_apps->num_rows == 0) echo "<p class='text-muted'>No recent applications.</p>"; ?>
      </div>

      <!-- Profile Completion -->
      <div class="glass-card-static slide-up" style="animation-delay:.5s">
        <h3 class="mb-3">Profile Completion</h3>
        <div class="progress-ring mb-3">
          <svg width="120" height="120" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="54" fill="none" stroke="#e0f7f5" stroke-width="10"/>
            <circle cx="60" cy="60" r="54" fill="none" stroke="var(--primary)" stroke-width="10"
              stroke-dasharray="339.3" stroke-dashoffset="84.8" stroke-linecap="round"
              transform="rotate(-90 60 60)"/>
          </svg>
          <div class="progress-ring-overlay">
            <span class="progress-ring-value">75%</span>
          </div>
        </div>
        <p class="text-center text-muted text-sm mb-3">Complete your profile to boost hiring chances.</p>
        <a href="profile.php" class="btn btn-outline w-full" style="display:block; text-align:center;">Complete Profile</a>
      </div>
    </div>
  </main>

  <script src="JS/script.js"></script>
</body>
</html>
