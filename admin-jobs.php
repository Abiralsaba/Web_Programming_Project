<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    // First delete related applications
    $conn->query("DELETE FROM applications WHERE job_id = $del_id");
    $conn->query("DELETE FROM jobs WHERE id = $del_id");
    header("Location: admin-jobs.php");
    exit();
}

$jobs = $conn->query("SELECT j.*, (SELECT COUNT(*) FROM applications WHERE job_id = j.id) as applicants FROM jobs j ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Jobs - Admin - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/admin-shared.css">
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
      <a href="admin-dashboard.php" class="sidebar-link">Dashboard</a>
      <a href="admin-jobs.php" class="sidebar-link active">Manage Jobs</a>
      <a href="admin-exams.php" class="sidebar-link">Manage Exams</a>
      <a href="admin-courses.php" class="sidebar-link">Manage Courses</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
    </aside>

    <main class="admin-main">
      <div class="flex-between mb-4">
        <h1>Manage Jobs</h1>
        <a href="admin-add-job.php" class="btn btn-primary">+ Create New Job</a>
      </div>

      <div class="glass-card-static table-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Job Title</th>
              <th>Company</th>
              <th>Status</th>
              <th>Applicants</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $jobs->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
              <td><?php echo htmlspecialchars($row['company']); ?></td>
              <td><span class="badge badge-success"><?php echo htmlspecialchars($row['status']); ?></span></td>
              <td><?php echo $row['applicants']; ?></td>
              <td>
                <a href="admin-jobs.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-ghost" style="padding:4px 8px; font-size:13px; color:#ef4444;" onclick="return confirm('Delete this job?');">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
            <?php if($jobs->num_rows == 0) echo "<tr><td colspan='6'>No jobs found.</td></tr>"; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>

</body>
</html>
