<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Courses - Admin - MAMA-KHALU.COM</title>
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
      <a href="admin-exams.php" class="sidebar-link">Manage Exams</a>
      <a href="admin-courses.php" class="sidebar-link active">Manage Courses</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
      <a href="admin-reports.php" class="sidebar-link">Reports & Analytics</a>
      <a href="admin-settings.php" class="sidebar-link">Settings</a>
    </aside>

    <main class="admin-main">
      <div class="flex-between mb-4">
        <h1>Course Library</h1>
        <button class="btn btn-primary">+ Upload Course</button>
      </div>

      <div class="grid-3">
        <div class="glass-card-static slide-up" style="padding:0; overflow:hidden;">
          <div class="flex-center" style="height:120px; background:var(--primary-light); font-size:32px;">⚛️</div>
          <div style="padding:16px;">
            <h3 class="mb-1 text-sm">Advanced React Concepts</h3>
            <p class="text-muted text-xs mb-3">Assigned to: React Basics v2 failures</p>
            <div class="flex-between">
              <span class="text-xs">12 Modules</span>
              <a href="#" class="text-primary text-xs font-medium">Edit Content</a>
            </div>
          </div>
        </div>
        
        <div class="glass-card-static slide-up" style="animation-delay: 0.1s; padding:0; overflow:hidden;">
          <div class="flex-center" style="height:120px; background:rgba(59, 130, 246, 0.1); font-size:32px;">🗄️</div>
          <div style="padding:16px;">
            <h3 class="mb-1 text-sm">Database Design</h3>
            <p class="text-muted text-xs mb-3">Assigned to: Node API Arch failures</p>
            <div class="flex-between">
              <span class="text-xs">8 Modules</span>
              <a href="#" class="text-primary text-xs font-medium">Edit Content</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
