<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['app_id'])) {
    $app_id = intval($_POST['app_id']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $app_id);
    $stmt->execute();
    header("Location: admin-applicants.php");
    exit();
}

$query = "
    SELECT a.id, a.status, a.resume_path, a.applied_at, 
           u.first_name, u.last_name, u.email,
           j.title as job_title
    FROM applications a
    JOIN users u ON a.user_id = u.id
    JOIN jobs j ON a.job_id = j.id
    ORDER BY a.applied_at DESC
";
$applicants = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Applicants - Admin - MAMA-KHALU.COM</title>
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
      <a href="admin-exams.php" class="sidebar-link">Exam Results</a>
      <a href="admin-applicants.php" class="sidebar-link active">Manage Applicants</a>
      <a href="admin-complaints.php" class="sidebar-link">Complaints</a>
    </aside>

    <main class="admin-main">
      <div class="flex-between mb-4">
        <h1>Applicant Tracking</h1>
      </div>

      <div class="glass-card-static table-card">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Applicant</th>
              <th>Applied For</th>
              <th>Applied At</th>
              <th>Status</th>
              <th>Resume</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $applicants->fetch_assoc()): ?>
            <tr>
              <td>
                <strong class="text-sm"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong><br>
                <span class="text-muted text-xs"><?php echo htmlspecialchars($row['email']); ?></span>
              </td>
              <td><?php echo htmlspecialchars($row['job_title']); ?></td>
              <td><?php echo date('M d, Y', strtotime($row['applied_at'])); ?></td>
              <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="app_id" value="<?php echo $row['id']; ?>">
                    <select name="status" class="form-input" style="padding:4px 8px; font-size:13px; width:auto;" onchange="this.form.submit()">
                      <option value="pending" <?php if($row['status'] == 'pending') echo 'selected'; ?>>Pending Review</option>
                      <option value="interviewing" <?php if($row['status'] == 'interviewing') echo 'selected'; ?>>Interviewing</option>
                      <option value="hired" <?php if($row['status'] == 'hired') echo 'selected'; ?>>Hired</option>
                      <option value="rejected" <?php if($row['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
                    </select>
                </form>
              </td>
              <td>
                <?php if($row['resume_path']): ?>
                    <a href="<?php echo htmlspecialchars($row['resume_path']); ?>" target="_blank" class="btn btn-ghost" style="padding:4px 8px; font-size:13px;">View Resume</a>
                <?php else: ?>
                    <span class="text-muted text-xs">No resume</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
            <?php if($applicants->num_rows == 0) echo "<tr><td colspan='5'>No applicants found.</td></tr>"; ?>
          </tbody>
        </table>
      </div>

    </main>
  </div>

</body>
</html>
