<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Exams - Admin - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/admin-shared.css">
</head>
<body class="admin-body">

  <nav class="glass-nav">
    <div class="container navbar flex-between" style="max-width:1400px;">
      <a href="index.php" class="logo">MAMA<span>KHALU</span> <span class="admin-badge-logo">ADMIN</span></a>
    </div>
  </nav>

  <div class="admin-layout">
    
    <aside class="admin-sidebar">
      <a href="admin-dashboard.php" class="sidebar-link">Dashboard</a>
      <a href="admin-jobs.php" class="sidebar-link">Manage Jobs</a>
      <a href="admin-exams.php" class="sidebar-link active">Manage Exams</a>
      <a href="admin-courses.php" class="sidebar-link">Manage Courses</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
      <a href="admin-reports.php" class="sidebar-link">Reports & Analytics</a>
      <a href="admin-settings.php" class="sidebar-link">Settings</a>
    </aside>

    <main class="admin-main">
      <div class="flex-between mb-4">
        <h1>Assessment Bank</h1>
        <button class="btn btn-primary">+ Create Exam</button>
      </div>

      <div class="grid-2">
        <div class="glass-card-static slide-up">
          <div class="flex-between mb-2">
            <h3>React Basics v2</h3>
            <span class="badge">15 Questions</span>
          </div>
          <p class="text-muted text-sm mb-3">Linked to: Frontend Developer (TechCorp)</p>
          <div class="flex-between text-xs text-muted mb-4">
            <span>Pass threshold: 80%</span>
            <span>Time limit: 15 mins</span>
          </div>
          <div class="flex-between gap-1">
            <button class="btn btn-outline w-full" style="padding:8px; font-size:13px;">Edit Questions</button>
            <button class="btn btn-outline w-full" style="padding:8px; font-size:13px;">Settings</button>
          </div>
        </div>

        <div class="glass-card-static slide-up" style="animation-delay: 0.1s;">
          <div class="flex-between mb-2">
            <h3>Node API Architecture</h3>
            <span class="badge">20 Questions</span>
          </div>
          <p class="text-muted text-sm mb-3">Linked to: Backend Engineer (DataSystems)</p>
          <div class="flex-between text-xs text-muted mb-4">
            <span>Pass threshold: 75%</span>
            <span>Time limit: 30 mins</span>
          </div>
          <div class="flex-between gap-1">
            <button class="btn btn-outline w-full" style="padding:8px; font-size:13px;">Edit Questions</button>
            <button class="btn btn-outline w-full" style="padding:8px; font-size:13px;">Settings</button>
          </div>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
