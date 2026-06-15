<?php
session_start();
require 'php with db class/db.php';

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

if (!$job) {
    die("Job not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Details - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/job-detail.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link nav-active">Browse Jobs</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="nav-link">Logout</a>
            <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5">
    <a href="jobs.php" class="btn btn-ghost mb-4" style="padding-left:0;">← Back to Jobs</a>

    <div class="job-detail-grid">
      
      <!-- Left Column -->
      <div class="glass-card slide-up">
        <div class="job-header mb-4">
          <div class="company-icon" id="company-icon"><?php echo substr($job['company'], 0, 1); ?></div>
          <div style="flex:1;">
            <h1 id="job-title" style="font-size:28px;"><?php echo htmlspecialchars($job['title']); ?></h1>
            <p id="job-company" class="text-muted" style="font-size:16px;"><?php echo htmlspecialchars($job['company']); ?></p>
          </div>
        </div>

        <div class="job-meta-row mb-4">
          <div>
            <p class="text-muted text-sm">Salary</p>
            <strong class="text-primary" id="job-salary" style="font-size:20px;"><?php echo htmlspecialchars($job['salary']); ?></strong>
          </div>
          <div>
            <p class="text-muted text-sm text-right">Location & Type</p>
            <strong id="job-location"><?php echo htmlspecialchars($job['location']) . ' · ' . htmlspecialchars($job['type']); ?></strong>
          </div>
        </div>

        <div class="mb-4">
          <h3 class="mb-2">About the Role</h3>
          <p class="text-muted mb-3">We are looking for an experienced professional to join our core team. You will be responsible for building scalable, robust features and ensuring high performance across our applications.</p>
          <ul class="req-list">
            <li>Collaborate with cross-functional teams</li>
            <li>Write clean, maintainable, and efficient code</li>
            <li>Participate in code reviews</li>
            <li>Optimize application for maximum speed</li>
          </ul>
        </div>
      </div>

      <!-- Right Column -->
      <div class="sidebar-layout">
        
        <div class="glass-card-static slide-up" style="animation-delay: 0.1s; text-align:center;">
          <h3 class="mb-2">Assessment Required</h3>
          <p class="text-muted text-sm mb-4">To unlock the application form for this role, you must pass a brief technical assessment (80% passing score).</p>
          <a id="take-exam-btn" href="exam.php?id=<?php echo $job['id']; ?>" class="btn btn-primary w-full">Take Assessment →</a>
        </div>

      </div>

    </div>
  </main>

</body>
</html>
