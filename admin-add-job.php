<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $company = $_POST['company'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $type = $_POST['type'];

    $stmt = $conn->prepare("INSERT INTO jobs (title, company, location, salary, type, status) VALUES (?, ?, ?, ?, ?, 'active')");
    $stmt->bind_param("sssss", $title, $company, $location, $salary, $type);
    
    if ($stmt->execute()) {
        header("Location: admin-jobs.php");
        exit();
    } else {
        $error = "Failed to add job.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Job - Admin</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/admin-shared.css">
</head>
<body class="admin-body">
  <nav class="glass-nav">
    <div class="container flex-between" style="max-width:1400px; padding: 15px;">
      <a href="index.php" class="logo">MAMA<span>KHALU</span> <span class="admin-badge-logo">ADMIN</span></a>
      <a href="admin-logout.php" class="text-muted">Logout</a>
    </div>
  </nav>

  <main class="container mt-4" style="max-width: 600px;">
    <h2>Create New Job</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <div class="glass-card mt-4">
        <form method="POST">
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Salary</label>
                <input type="text" name="salary" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-input" required>
            </div>
            <button type="submit" class="btn btn-primary w-full">Save Job</button>
            <a href="admin-jobs.php" class="btn btn-ghost w-full mt-2 text-center" style="display:block;">Cancel</a>
        </form>
    </div>
  </main>
</body>
</html>
