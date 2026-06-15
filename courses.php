<?php session_start(); ?>
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
        <span class="badge badge-warning mb-2">Required to Retake Exam</span>
        <h1 class="mb-1" style="font-size:28px;">Core Frontend Concepts</h1>
        <p class="text-muted">Assigned based on your recent assessment.</p>
      </div>
      <div class="text-right">
        <span class="text-muted text-sm">Course Progress</span>
        <h2 class="text-primary">0%</h2>
      </div>
    </div>

    <div class="course-layout">
      
      <!-- Video Area -->
      <div class="glass-card-static video-player-card slide-up">
        <div class="video-placeholder">
          <div class="play-btn">▶</div>
          <p class="video-overlay">1. Introduction</p>
        </div>
        <div class="module-info">
          <h2 class="mb-2">1. Introduction to Core Concepts</h2>
          <p class="text-muted mb-3">In this module, we will cover the fundamental concepts you missed during the assessment.</p>
          <button class="btn btn-primary" onclick="alert('Module marked as complete!');">Mark Complete & Next →</button>
        </div>
      </div>

      <!-- Modules List -->
      <div class="glass-card-static slide-up" style="animation-delay: 0.1s; height: fit-content;">
        <h3 class="mb-3">Course Modules</h3>
        
        <div class="flex-col gap-1">
          <div class="module-item active">
            <div class="module-icon">▶</div>
            <div>
              <p class="font-medium text-sm">1. Introduction</p>
              <p class="text-muted text-xs">12 mins</p>
            </div>
          </div>

          <div class="module-item locked">
            <div class="module-icon">🔒</div>
            <div>
              <p class="font-medium text-sm">2. Deep Dive</p>
              <p class="text-muted text-xs">18 mins</p>
            </div>
          </div>

          <div class="module-item locked">
            <div class="module-icon">🔒</div>
            <div>
              <p class="font-medium text-sm">3. Practical Application</p>
              <p class="text-muted text-xs">25 mins</p>
            </div>
          </div>
        </div>

        <div class="retake-box">
          <button class="btn btn-outline w-full" disabled style="opacity:0.5;cursor:not-allowed;">Retake Assessment</button>
          <p class="text-center text-muted text-xs mt-2">Complete all modules to unlock</p>
        </div>
      </div>

    </div>

  </main>

  <script src="JS/script.js"></script>
</body>
</html>
