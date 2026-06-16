<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$job_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['job_id']) ? intval($_POST['job_id']) : 1);

$user_id = $_SESSION['user_id'];

$chk = $conn->query("SELECT score FROM exam_results WHERE user_id = $user_id AND job_id = $job_id AND passed = 1 ORDER BY taken_at DESC LIMIT 1");
if ($chk->num_rows == 0) {
    die("You must pass the assessment before applying for this job. <a href='job-detail.php?id=$job_id'>Go back</a>");
}
$score = $chk->fetch_assoc()['score'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
   
    $resume_path = "";
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $resume_path = $target_dir . basename($_FILES["resume"]["name"]);
        move_uploaded_file($_FILES["resume"]["tmp_name"], $resume_path);
    }

    $stmt = $conn->prepare("INSERT INTO applications (user_id, job_id, resume_path, score) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $user_id, $job_id, $resume_path, $score);
    
    if ($stmt->execute()) {
        echo "<script>alert('Application Submitted Successfully!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        $error = "Application failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/apply.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
      </div>
    </div>
  </nav>

  <main class="container mt-5 mb-5 apply-wrapper">
    
    <div class="mb-4 text-center">
      <span class="badge badge-success mb-2">✓ Assessment Passed</span>
      <h1 class="mb-1">Submit Application</h1>
      <p class="text-muted">You're applying for the selected role.</p>
    </div>

    <div class="glass-card-static slide-up">
      <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
        <div class="grid-2 mb-3">
          <div class="form-group">
            <label class="form-label">First Name</label>
            <input type="text" class="form-input" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-input" required>
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Email Address</label>
          <input type="email" class="form-input" required>
        </div>

        <div class="form-group mb-4">
          <label class="form-label">Resume / CV</label>
          <div class="upload-zone" style="text-align:center;">
             <input type="file" name="resume" required style="margin-top:15px; margin-bottom:15px;">
          </div>
        </div>

        <div class="form-group mb-4">
          <label class="form-label">Cover Letter (Optional)</label>
          <textarea class="form-input" rows="4" placeholder="Tell the company why you're a great fit..."></textarea>
        </div>

        <div class="flex-between">
          <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
          <button type="submit" class="btn btn-primary">Submit Application</button>
        </div>

      </form>
    </div>

  </main>

</body>
</html>
