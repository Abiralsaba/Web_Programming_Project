<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$app_result = $conn->query("SELECT COUNT(*) as total FROM applications");
$app_count = $app_result->fetch_assoc()['total'];

$jobs_result = $conn->query("SELECT COUNT(*) as total FROM jobs");
$jobs_count = $jobs_result->fetch_assoc()['total'];

$users_result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
$users_count = $users_result->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/admin-shared.css">
  <link rel="stylesheet" href="CSS/admin-dashboard.css">
</head>
<body class="admin-body">

  <nav class="glass-nav">
    <div class="container navbar flex-between" style="max-width:1400px;">
      <a href="index.php" class="logo">MAMA<span>KHALU</span> <span class="admin-badge-logo">ADMIN</span></a>
      <div style="display:flex; gap:15px; align-items:center;">
          <a href="admin-logout.php" class="text-muted">Logout</a>
          <div class="avatar">AD</div>
      </div>
    </div>
  </nav>

  <div class="admin-layout">
    
    <aside class="admin-sidebar">
      <a href="admin-dashboard.php" class="sidebar-link active">Dashboard</a>
      <a href="admin-jobs.php" class="sidebar-link">Manage Jobs</a>
      <a href="admin-exams.php" class="sidebar-link">Manage Exams</a>
      <a href="admin-courses.php" class="sidebar-link">Manage Courses</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
    </aside>

    <main class="admin-main">
      <h1 class="mb-4">Platform Overview</h1>

      <div class="grid-4 mb-5">
        <div class="glass-card-static slide-up">
          <p class="text-muted text-sm mb-1">Total Applications</p>
          <h2><?php echo $app_count; ?></h2>
          <span class="text-primary text-xs">Submitted Resumes</span>
        </div>
        <div class="glass-card-static slide-up" style="animation-delay: 0.1s; background: rgba(16, 185, 129, 0.05); border:none;">
          <p class="text-muted text-sm mb-1">Total Users</p>
          <h2 style="color: #047857;"><?php echo $users_count; ?></h2>
          <span class="text-xs" style="color: #047857;">Registered Candidates</span>
        </div>
        <div class="glass-card-static slide-up" style="animation-delay: 0.2s;">
          <p class="text-muted text-sm mb-1">Active Jobs</p>
          <h2><?php echo $jobs_count; ?></h2>
          <span class="text-muted text-xs">Job Postings</span>
        </div>
      </div>

      <div class="grid-2">
        <!-- Mock Chart Area -->
        <div class="glass-card-static slide-up">
          <h3 class="mb-4">Applicant Growth</h3>
          <div class="flex-between align-end" style="height:200px; border-bottom:1px solid rgba(0,0,0,0.1); padding-bottom:8px; gap:8px;">
            <div style="flex:1; background:var(--primary); height:40%; border-radius:4px 4px 0 0;"></div>
            <div style="flex:1; background:var(--primary); height:50%; border-radius:4px 4px 0 0;"></div>
            <div style="flex:1; background:var(--primary); height:45%; border-radius:4px 4px 0 0;"></div>
            <div style="flex:1; background:var(--primary); height:70%; border-radius:4px 4px 0 0;"></div>
            <div style="flex:1; background:var(--primary); height:60%; border-radius:4px 4px 0 0;"></div>
            <div style="flex:1; background:var(--gradient); height:90%; border-radius:4px 4px 0 0;"></div>
          </div>
          <div class="flex-between mt-2 text-muted text-xs">
            <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
          </div>
        </div>

        <div class="glass-card-static slide-up" style="animation-delay: 0.1s;">
          <h3 class="mb-3">Recent Activity</h3>
          <div class="flex-col gap-2">
            <div class="flex-between pb-2" style="border-bottom:1px solid rgba(0,0,0,0.05);">
              <div>
                <strong class="text-sm">New job posted</strong>
                <p class="text-muted text-xs">TechCorp: Senior React Developer</p>
              </div>
              <span class="text-muted text-xs">2m ago</span>
            </div>
            <div class="flex-between pb-2" style="border-bottom:1px solid rgba(0,0,0,0.05);">
              <div>
                <strong class="text-sm" style="color:var(--primary-dark);">Exam passed (95%)</strong>
                <p class="text-muted text-xs">John Doe → Frontend Developer</p>
              </div>
              <span class="text-muted text-xs">15m ago</span>
            </div>
            <div class="flex-between">
              <div>
                <strong class="text-sm">Course completed</strong>
                <p class="text-muted text-xs">Jane Smith: Intro to Hooks</p>
              </div>
              <span class="text-muted text-xs">1h ago</span>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>

</body>
</html>
