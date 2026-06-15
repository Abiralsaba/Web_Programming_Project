<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$score = isset($_SESSION['last_exam_score']) ? $_SESSION['last_exam_score'] : 0;
$job_id = isset($_SESSION['last_exam_job']) ? $_SESSION['last_exam_job'] : 1;

$passed = $score >= 80;

$stmt = $conn->prepare("SELECT title FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$job_res = $stmt->get_result();
$job_title = $job_res->num_rows > 0 ? $job_res->fetch_assoc()['title'] : "Assessment";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Result - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/exam.css">
</head>
<body style="display:flex; align-items:center; justify-content:center; min-height:100vh;">

  <div class="glass-card-static text-center" style="max-width:400px; padding:40px;">
    
    <div class="score-circle <?php echo $passed ? 'pass' : 'fail'; ?>" id="score-circle" style="margin: 0 auto 24px;">
      <span class="score-val" id="result-score"><?php echo $score; ?>%</span>
    </div>

    <div style="font-size:40px; margin-bottom:16px;" id="result-icon"><?php echo $passed ? '🎉' : '📚'; ?></div>
    
    <h2 class="mb-2" id="result-title"><?php echo $passed ? 'Congratulations! You Passed!' : 'Keep Going! You Can Do Better.'; ?></h2>
    <p class="text-muted mb-4" id="result-msg">
        <?php 
        if($passed) {
            echo "You scored above the 80% threshold for " . htmlspecialchars($job_title) . ". You can now submit your application.";
        } else {
            echo "You need 80% to pass. We have assigned a skill-building course to help you improve.";
        }
        ?>
    </p>

    <div id="result-action">
        <?php if($passed): ?>
            <a href="apply.php?id=<?php echo $job_id; ?>&score=<?php echo $score; ?>" class="btn btn-primary w-full">Proceed to Application →</a>
        <?php else: ?>
            <a href="courses.php" class="btn btn-primary w-full">Start Assigned Course →</a>
            <a href="jobs.php" class="btn btn-ghost w-full mt-2">Back to Jobs</a>
        <?php endif; ?>
    </div>

  </div>

</body>
</html>
