<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MAMA-KHALU.COM — Skill-Based Recruitment</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/index.css">
  <meta name="description" content="A premium, skill-first job recruitment platform.">
</head>
<body>

<?php session_start(); ?>
  <!-- Nav -->
  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="jobs.php" class="nav-link">Browse Jobs</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="nav-link">Dashboard</a>
            <a href="my-applications.php" class="nav-link">My Applications</a>
            <a href="logout.php" class="btn btn-outline">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
            <a href="login.php" class="btn btn-primary">Get Started</a>
        <?php endif; ?>
        <?php if(!isset($_SESSION['admin_id'])): ?>
            <a href="admin-login.php" class="nav-link text-muted nav-admin">Admin</a>
        <?php else: ?>
            <a href="admin-dashboard.php" class="nav-link text-muted nav-admin">Admin Dashboard</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <header class="container hero">
    <div class="slide-up">
      <span class="badge mb-3">#1 Skill-Based Hiring Platform</span>
      <h1 class="hero-title">Find Your Dream Job<br><span class="hero-highlight">With Skill-Based Hiring</span></h1>
      <p class="hero-sub">No more resume black holes. Prove your skills, bypass the screening phase, and connect directly with top employers.</p>
      <div class="hero-btns">
        <a href="jobs.php" class="btn btn-primary">Browse Jobs</a>
        <a href="login.php" class="btn btn-outline">Create Profile</a>
      </div>
    </div>
  </header>

  <!-- Stats -->
  <section class="container mb-5 slide-up">
    <div class="glass-card grid-3 stats-bar">
      <div>
        <div class="stat-num">2,500+</div>
        <p class="text-muted">Active Jobs</p>
      </div>
      <div>
        <div class="stat-num">15K+</div>
        <p class="text-muted">Successful Hires</p>
      </div>
      <div>
        <div class="stat-num">94%</div>
        <p class="text-muted">Success Rate</p>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="container mb-5">
    <h2 class="text-center mb-4">Why Choose MAMA-KHALU?</h2>
    <div class="grid-3">
      <div class="glass-card text-center">
        <div class="feature-icon">🎯</div>
        <h3 class="mb-2">Skill-Based Matching</h3>
        <p class="text-muted">Your skills matter more than your resume. Take assessments to prove your worth.</p>
      </div>
      <div class="glass-card text-center">
        <div class="feature-icon">⚡</div>
        <h3 class="mb-2">Instant Feedback</h3>
        <p class="text-muted">Get immediate results on your assessments. Pass and apply directly.</p>
      </div>
      <div class="glass-card text-center">
        <div class="feature-icon">📚</div>
        <h3 class="mb-2">Career Acceleration</h3>
        <p class="text-muted">Didn't pass? We provide tailored courses to help you upskill and try again.</p>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="container mb-5">
    <h2 class="text-center mb-4">How It Works</h2>
    <div class="grid-4">
      <div class="glass-card text-center">
        <div class="stat-num mb-1">1</div>
        <h4 class="mb-1">Create Profile</h4>
        <p class="text-muted text-sm">Sign up and tell us about your skills.</p>
      </div>
      <div class="glass-card text-center">
        <div class="stat-num mb-1">2</div>
        <h4 class="mb-1">Browse Jobs</h4>
        <p class="text-muted text-sm">Find roles that match your expertise.</p>
      </div>
      <div class="glass-card text-center">
        <div class="stat-num mb-1">3</div>
        <h4 class="mb-1">Take Assessment</h4>
        <p class="text-muted text-sm">Pass a technical exam to unlock the apply button.</p>
      </div>
      <div class="glass-card text-center">
        <div class="stat-num mb-1">4</div>
        <h4 class="mb-1">Get Hired</h4>
        <p class="text-muted text-sm">Submit your application and land interviews.</p>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="container mb-5">
    <div class="cta-box">
      <h2 class="mb-3">Ready to Transform Your Career?</h2>
      <p class="mb-4">Join thousands of professionals who found their dream jobs through skill-based hiring.</p>
      <a href="login.php" class="btn cta-btn">Get Started Now</a>
    </div>
  </section>

  <footer class="text-center text-muted footer">
    <p>© 2026 MAMA-KHALU.COM. All rights reserved.</p>
  </footer>

  <script src="JS/script.js"></script>
</body>
</html>
