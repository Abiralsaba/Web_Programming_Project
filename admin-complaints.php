<?php
session_start();
require 'php with db class/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complaint_id']) && isset($_POST['action'])) {
    $cid = (int)$_POST['complaint_id'];
    $action = $_POST['action'];
    if ($action == 'resolve') {
        $conn->query("UPDATE complaints SET status = 'resolved' WHERE id = $cid");
    } else if ($action == 'reject') {
        $conn->query("UPDATE complaints SET status = 'rejected' WHERE id = $cid");
    }
    header("Location: admin-complaints.php");
    exit();
}

$complaints = $conn->query("
    SELECT c.*, u.first_name, u.last_name, u.email 
    FROM complaints c 
    JOIN users u ON c.user_id = u.id 
    ORDER BY c.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints - Admin - MAMA-KHALU.COM</title>
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
      <a href="admin-dashboard.php" class="sidebar-link">Dashboard</a>
      <a href="admin-jobs.php" class="sidebar-link">Manage Jobs</a>
      <a href="admin-exams.php" class="sidebar-link">Exam Results</a>
      <a href="admin-applicants.php" class="sidebar-link">Manage Applicants</a>
      <a href="admin-complaints.php" class="sidebar-link active">Complaints</a>
    </aside>

    <main class="admin-main">
      <h1 class="mb-4">User Complaints</h1>

      <?php if($complaints->num_rows == 0): ?>
        <div class="glass-card-static">
          <p class="text-muted text-center py-4">No complaints received yet.</p>
        </div>
      <?php else: ?>
        <?php while($row = $complaints->fetch_assoc()): ?>
        <div class="glass-card-static slide-up mb-3">
          <div class="flex-between mb-2">
            <div>
              <h3><?php echo htmlspecialchars($row['subject']); ?></h3>
              <p class="text-muted text-sm">From: <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?> (<?php echo htmlspecialchars($row['email']); ?>)</p>
            </div>
            <div class="text-right">
              <?php
                $badge = 'badge-info';
                if ($row['status'] == 'resolved') $badge = 'badge-success';
                if ($row['status'] == 'rejected') $badge = 'badge-danger';
              ?>
              <span class="badge <?php echo $badge; ?>"><?php echo ucfirst($row['status']); ?></span>
              <p class="text-muted text-xs mt-1"><?php echo date('M d, Y - h:i A', strtotime($row['created_at'])); ?></p>
            </div>
          </div>
          <p class="mb-3" style="background: rgba(0,0,0,0.02); padding: 12px; border-radius: 8px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
          <?php if($row['status'] == 'pending'): ?>
          <div style="display:flex; gap:10px;">
            <form method="POST" style="flex:1;">
              <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="action" value="resolve">
              <button type="submit" class="btn btn-primary w-full">Mark Resolved</button>
            </form>
            <form method="POST" style="flex:1;">
              <input type="hidden" name="complaint_id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="action" value="reject">
              <button type="submit" class="btn btn-outline w-full" style="color:red; border-color:red;">Reject</button>
            </form>
          </div>
          <?php endif; ?>
        </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </main>
  </div>

</body>
</html>
