<?php
session_start();
require 'php with db class/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$modules = [
    ['name' => 'Introduction', 'desc' => 'In this module, we will cover the fundamental concepts you missed during the assessment.', 'duration' => '12 mins'],
    ['name' => 'Deep Dive', 'desc' => 'A deeper look into how these core concepts work together in real projects.', 'duration' => '18 mins'],
    ['name' => 'Practical Application', 'desc' => 'Hands-on practice applying what you have learned so far.', 'duration' => '25 mins']
];

$job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : 0;

if (!isset($_SESSION['course_progress'])) {
    $_SESSION['course_progress'] = [];
}
$key = 'job_' . $job_id;
if (!isset($_SESSION['course_progress'][$key])) {
    $_SESSION['course_progress'][$key] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete_module'])) {
    $mod = (int)$_POST['complete_module'];
    if ($mod == $_SESSION['course_progress'][$key]) {
        $_SESSION['course_progress'][$key] = $mod + 1;
    }
    header("Location: courses.php?job_id=$job_id");
    exit();
}

$completed = $_SESSION['course_progress'][$key];
$total = count($modules);
$progress = round(($completed / $total) * 100);
$all_done = ($completed >= $total);

$job_title = "Core Frontend Concepts";
if ($job_id > 0) {
    $jq = $conn->query("SELECT title FROM jobs WHERE id = $job_id");
    if ($jq->num_rows > 0) {
        $job_title = $jq->fetch_assoc()['title'] . " - Core Concepts";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/courses.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link">Browse Jobs</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="nav-link">Logout</a>
            <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5">
    
    <div class="flex-between mb-4">
      <div>
        <?php if($all_done): ?>
          <span class="badge badge-success mb-2">Course Complete!</span>
        <?php else: ?>
          <span class="badge badge-warning mb-2">Required to Retake Exam</span>
        <?php endif; ?>
        <h1 class="mb-1" style="font-size:28px;"><?php echo htmlspecialchars($job_title); ?></h1>
        <p class="text-muted">Assigned based on your recent assessment.</p>
      </div>
      <div class="text-right">
        <span class="text-muted text-sm">Course Progress</span>
        <h2 class="text-primary"><?php echo $progress; ?>%</h2>
      </div>
    </div>

    <div class="course-layout">
      
      <!-- Video Area -->
      <div class="glass-card-static video-player-card slide-up">
        <div class="video-placeholder">
          <div class="play-btn">▶</div>
          <?php if($all_done): ?>
            <p class="video-overlay">All modules completed!</p>
          <?php else: ?>
            <p class="video-overlay"><?php echo ($completed + 1) . '. ' . $modules[$completed]['name']; ?></p>
          <?php endif; ?>
        </div>
        <div class="module-info">
          <?php if($all_done): ?>
            <h2 class="mb-2">All Modules Completed!</h2>
            <p class="text-muted mb-3">You have finished all course modules. You can now retake the assessment.</p>
          <?php else: ?>
            <h2 class="mb-2"><?php echo ($completed + 1) . '. ' . $modules[$completed]['name']; ?></h2>
            <p class="text-muted mb-3"><?php echo $modules[$completed]['desc']; ?></p>
            <form method="POST">
              <input type="hidden" name="complete_module" value="<?php echo $completed; ?>">
              <button type="submit" class="btn btn-primary">Mark Complete & Next →</button>
            </form>
          <?php endif; ?>
        </div>
      </div>

      <!-- Modules List -->
      <div class="glass-card-static slide-up" style="animation-delay: 0.1s; height: fit-content;">
        <h3 class="mb-3">Course Modules</h3>
        
        <div class="flex-col gap-1">
          <?php for($i = 0; $i < $total; $i++): ?>
          <div class="module-item <?php if($i == $completed && !$all_done) echo 'active'; elseif($i < $completed) echo 'done'; else echo 'locked'; ?>">
            <div class="module-icon">
              <?php if($i < $completed): ?>✅
              <?php elseif($i == $completed && !$all_done): ?>▶
              <?php else: ?>🔒
              <?php endif; ?>
            </div>
            <div>
              <p class="font-medium text-sm"><?php echo ($i + 1) . '. ' . $modules[$i]['name']; ?></p>
              <p class="text-muted text-xs"><?php echo $modules[$i]['duration']; ?></p>
            </div>
          </div>
          <?php endfor; ?>
        </div>

        <div class="retake-box">
          <?php if($all_done): ?>
            <a href="exam.php?job_id=<?php echo $job_id; ?>" class="btn btn-primary w-full" style="display:block; text-align:center;">Retake Assessment</a>
            <p class="text-center text-muted text-xs mt-2">All modules completed — you're ready!</p>
          <?php else: ?>
            <button class="btn btn-outline w-full" disabled style="opacity:0.5;cursor:not-allowed;">Retake Assessment</button>
            <p class="text-center text-muted text-xs mt-2">Complete all modules to unlock</p>
          <?php endif; ?>
        </div>
      </div>

    </div>

  </main>

  <script src="JS/script.js"></script>
</body>
</html>
