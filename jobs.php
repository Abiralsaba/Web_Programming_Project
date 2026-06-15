<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jobs - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/jobs.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link nav-active">Browse Jobs</a>
        <a href="#" class="nav-link">My Applications</a>
        <div class="avatar">JD</div>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5">
    <div class="flex-between mb-4">
      <div>
        <h1 class="mb-1">Find Your Dream Job</h1>
        <p class="text-muted">Browse open roles and take skill assessments to apply.</p>
      </div>
      <div class="search-row">
        <input type="text" class="form-input" placeholder="Search jobs…">
        <button class="btn btn-primary">Search</button>
      </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-bar mb-4">
      <span class="filter-tab active">All Jobs (6)</span>
      <span class="filter-tab">Frontend (2)</span>
      <span class="filter-tab">Backend (1)</span>
      <span class="filter-tab">Full Stack (1)</span>
      <span class="filter-tab">Design (1)</span>
      <span class="filter-tab">DevOps (1)</span>
    </div>

    <!-- Job Cards -->
    <div class="grid-3">
      <?php
      require 'php with db class/db.php';
      $sql = "SELECT * FROM jobs";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="glass-card slide-up">';
              echo '<h3 class="mb-1">' . htmlspecialchars($row['title']) . '</h3>';
              echo '<p class="text-muted mb-2 text-sm">' . htmlspecialchars($row['company']) . ' · ' . htmlspecialchars($row['location']) . '</p>';
              echo '<div class="flex-between">';
              echo '<strong class="text-primary">' . htmlspecialchars($row['salary']) . '</strong>';
              echo '<a href="job-detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Job</a>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo "<p>No jobs found.</p>";
      }
      ?>
    </div>
  </main>

  <script src="JS/script.js"></script>
</body>
</html>
