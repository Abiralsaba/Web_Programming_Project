<?php
session_start();
require 'php with db class/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $message = $conn->real_escape_string(trim($_POST['message']));
    $conn->query("INSERT INTO complaints (user_id, subject, message) VALUES ($user_id, '$subject', '$message')");
    $success = true;
}

$my_complaints = $conn->query("SELECT * FROM complaints WHERE user_id = $user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaints - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/dashboard.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link">Browse Jobs</a>
        <a href="complaint.php" class="nav-link nav-active">Complaints</a>
        <a href="logout.php" class="nav-link">Logout</a>
        <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5" style="max-width: 800px;">
    <h1 class="mb-3">Submit a Complaint</h1>

    <?php if($success): ?>
      <div class="glass-card-static mb-3" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid var(--primary);">
        <p style="color: var(--primary-dark); font-weight: 600;">Your complaint has been submitted successfully!</p>
      </div>
    <?php endif; ?>

    <div class="glass-card slide-up mb-4">
      <form method="POST">
        <div class="form-group mb-3">
          <label class="form-label">Subject</label>
          <input type="text" name="subject" class="form-input" placeholder="Brief description of your issue" required>
        </div>
        <div class="form-group mb-3">
          <label class="form-label">Message</label>
          <textarea name="message" class="form-input" rows="5" placeholder="Describe your complaint in detail..." required style="resize: vertical;"></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-full">Submit Complaint</button>
      </form>
    </div>

    <h2 class="mb-3">My Previous Complaints</h2>
    <div class="glass-card-static slide-up">
      <?php while($row = $my_complaints->fetch_assoc()): ?>
      <div class="app-row" style="margin-bottom:15px; border-bottom:1px solid rgba(0,0,0,0.05); padding-bottom:15px;">
        <div>
          <h4><?php echo htmlspecialchars($row['subject']); ?></h4>
          <p class="text-muted text-sm mt-1"><?php echo htmlspecialchars($row['message']); ?></p>
          <p class="text-muted text-xs mt-1"><?php echo date('M d, Y - h:i A', strtotime($row['created_at'])); ?></p>
        </div>
        <div class="text-right">
          <?php
            $badge = 'badge-info';
            if ($row['status'] == 'resolved') $badge = 'badge-success';
            if ($row['status'] == 'rejected') $badge = 'badge-danger';
          ?>
          <span class="badge <?php echo $badge; ?>"><?php echo ucfirst($row['status']); ?></span>
        </div>
      </div>
      <?php endwhile; ?>
      <?php if($my_complaints->num_rows == 0) echo "<p class='text-muted text-center py-4'>You haven't submitted any complaints yet.</p>"; ?>
    </div>
  </main>

  <script src="JS/script.js"></script>
</body>
</html>
