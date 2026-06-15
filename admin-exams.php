<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$query = "
    SELECT e.score, e.passed, e.taken_at,
           u.first_name, u.last_name, u.email,
           j.title as job_title
    FROM exam_results e
    JOIN users u ON e.user_id = u.id
    JOIN jobs j ON e.job_id = j.id
    ORDER BY e.taken_at DESC
";
$results = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Results - Admin - MAMA-KHALU.COM</title>
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
      <a href="admin-jobs.php" class="sidebar-link">Manage Jobs</a>
      <a href="admin-exams.php" class="sidebar-link active">Exam Results</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
    </aside>

    <main class="admin-main">
      <div class="flex-between mb-4">
        <h1>Candidate Exam Results</h1>
      </div>

      <div class="glass-card-static table-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Candidate</th>
              <th>Exam (Job)</th>
              <th>Score</th>
              <th>Result</th>
              <th>Taken At</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $results->fetch_assoc()): ?>
            <tr>
              <td>
                <strong class="text-sm"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong><br>
                <span class="text-muted text-xs"><?php echo htmlspecialchars($row['email']); ?></span>
              </td>
              <td><?php echo htmlspecialchars($row['job_title']); ?></td>
              <td><strong class="text-sm"><?php echo $row['score']; ?>%</strong></td>
              <td>
                <?php if($row['passed']): ?>
                    <span class="badge badge-success">Passed</span>
                <?php else: ?>
                    <span class="badge badge-warning">Failed</span>
                <?php endif; ?>
              </td>
              <td><?php echo date('M d, Y', strtotime($row['taken_at'])); ?></td>
            </tr>
            <?php endwhile; ?>
            <?php if($results->num_rows == 0) echo "<tr><td colspan='5'>No exams taken yet.</td></tr>"; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>

</body>
</html>
