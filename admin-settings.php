<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings - Admin - MAMA-KHALU.COM</title>
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
      <a href="admin-courses.php" class="sidebar-link">Manage Courses</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
      <a href="admin-reports.php" class="sidebar-link">Reports & Analytics</a>
      <a href="admin-settings.php" class="sidebar-link active">Settings</a>
    </aside>

    <main class="admin-main">
      <h1 class="mb-4">Platform Settings</h1>
      
      <div class="glass-card-static slide-up" style="max-width:600px;">
        <h3 class="mb-3">Global Configuration</h3>
        
        <div class="form-group">
          <label class="form-label">Platform Name</label>
          <input type="text" class="form-input" value="MAMA-KHALU.COM">
        </div>
        
        <div class="form-group">
          <label class="form-label">Default Passing Score (%)</label>
          <input type="number" class="form-input" value="80">
        </div>
        
        <div class="form-group flex-between">
          <div>
            <label class="form-label" style="margin-bottom:4px;">Auto-Assign Courses</label>
            <p class="text-muted text-xs">Automatically assign remedial courses upon exam failure</p>
          </div>
          <input type="checkbox" checked style="width:20px; height:20px; accent-color:var(--primary);">
        </div>
        
        <button class="btn btn-primary mt-4">Save Settings</button>
      </div>

    </main>
  </div>

</body>
</html>
